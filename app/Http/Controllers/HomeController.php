<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Socialite;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Task;
use App\Questions;
use App\Answers;
use App\User;
use App\Scores;
use App\Registered;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
      if (isset(Auth::user()->name)) {

      } else {
        return redirect()->route('/redirect');
      }
        return view('/home', [
            'quizes' => Task::orderBy('created_at', 'asc')->get(),
            'user' => Auth::user()
        ]);
    }


    public function redirectToProvider(){
            return Socialite::driver('facebook')->redirect();
        }

        /**
         * Obtain the user information from Facebook.
         *
         * @return Response
         */
        public function handleProviderCallback(){
            try{
                $user = Socialite::driver('facebook')->fields([
                        'name',
                        'first_name',
                        'last_name',
                        'email',
                        'gender',
                        'verified'
                    ])->user();
            } catch (\Exception $e) {
                return redirect('/login')->with('status', 'Something went wrong or You have rejected the app!');
            }

            $authUser = $this->findOrCreateUser($user);

            Auth::login($authUser, true);

            return redirect()->route('/');
        }

        /**
         * Return user if exists; create and return if doesn't
         *
         * @param $facebookUser
         * @return User
         */
        private function findOrCreateUser($facebookUser)
        {
            $authUser = User::where('name', $facebookUser->name)->first();

            if ($authUser) {
              return $authUser;
            }

            if($facebookUser->email == '') {
              $facebookUser->email = 'test@gmail.com';
            }
            return User::create([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'first_name' => $facebookUser->user['first_name'],
                'last_name' => $facebookUser->user['last_name'],
                'phone' => '',
            ]);
        }


    public function showQuiz($id)
    {
        $quiz = Task::find($id);
        $questions = Questions::where('parent_id', $id)->first();
        $allQuestions = Questions::where('parent_id', $id)->get();
        $answers =  Answers::where('parent_id', $questions->id)->get();
        return view('quiz.index', [
          'quiz' => $quiz,
          'questions' => $questions,
          'answers' => $answers,
          'questNumber' => count($allQuestions),
          'questNumer' => 0,
          'score' => 0
        ]);
    }

    public function nextQuestion(Request $request, $parentId, $id)
    {
      $quiz = Task::find($parentId);
      $questions = Questions::where('parent_id', $parentId)->get();
      $questions = $questions[$request->questNum];
      $allQuestions = Questions::where('parent_id', $parentId)->get();
      $answers =  Answers::where('parent_id', $questions->id)->get();

      if($request->type == 'multiple') { //Если это мульти-выборочный опрос
        $score = 0; //Баллы
        foreach ($request->answer as $answer) {
          $answer = explode(" ", $answer);//Разбиваем на 2 части: 1-id вопроса; 2-id ответа
          $currentScore = Answers::find($answer[1]);
          if(isset($request->score)) {
            $score += $currentScore->points;
          }
        }
        $score += $request->score;
      } else { //Если это не мульти-выборочный опрос
        $answer = explode(" ", $request->answer);//Разбиваем на 2 части: 1-id вопроса; 2-id ответа
        $score = 0; //Баллы
        if ($answer[1] == "text") { //Если это свободный вопрос
          $textAnswers = Answers::where('parent_id', $answer[0])->get();
          foreach ($textAnswers as $answer) {
            if(strnatcasecmp(strip_tags($request->text_answer), $answer->name) == 0) {
              $score +=  $answer->points;
            }
          }
          $score += $request->score;
        } else { //Если это выборочный вопрос
          $score = Answers::find($answer[1]);
          if(isset($request->score)) {
            $score = $score->points+$request->score;
          }
        }
      }
      return view('quiz.index', [
        'quiz' => $quiz,
        'questions' => $questions,
        'answers' => $answers,
        'questNumber' => count($allQuestions),
        'questNumer' => $request->questNum,
        'score' => $score
      ]);
    }

    public function endQuiz(Request $request, $quizId)
    {

      $score = 0;

      if($request->type == 'multiple') { //Если это мульти-выборочный опрос
        $score = 0; //Баллы
        foreach ($request->answer as $answer) {
          $answer = explode(" ", $answer);//Разбиваем на 2 части: 1-id вопроса; 2-id ответа

          $currentScore = Answers::find($answer[1]);
          if(isset($request->score)) {
            $score += $currentScore->points;
          }
        }
      } else {
        if (isset($request->text_answer)) { //Если это свободный вопрос
          $answer = explode(" ", $request->answer);//Разбиваем на 2 части: 1-id вопроса; 2-id ответа
          $answers = Answers::where('parent_id', $answer[0])->get();
          foreach ($answers as $answer) {
            if(strnatcasecmp(strip_tags($request->text_answer), $answer->name) == 0) {
              $score =  $answer->points;
            }
          }
        } else { //Если это выборочный вопрос
          $answer = explode(" ", $request->answer);//Ответ в форме [0 - id вопрсоа, 1 - id ответа]
          $score = Answers::find($answer[1]);
          $score = $score->points;
        }
      }


      if(Scores::where(['user_id' => Auth::user()->id, 'quiz_id' => $quizId])->count() > 0) { //Если пользователь уже проходил этот тест
        $allScore = Scores::where(['user_id' => Auth::user()->id, 'quiz_id' => $quizId])->first();
        $allScore->score  = $score+$request->score;
        $allScore->save();
      } else { //Если пользователь еще не проходил этот тест
        $allScore = new Scores;
        $allScore->user_id = Auth::user()->id;
        $allScore->quiz_id = $quizId;
        $allScore->score = $score+$request->score;
        $allScore->save();
      }


      return view('quiz.result', [
        'score' => $score+$request->score
      ]);
    }

    public function scores()
    {
      $scores = Scores::orderBy('created_at', 'asc')->get();
      $arr = [];
      $i = 0;
      foreach ($scores as $score) {
        $d = "false";
        $quizes = Scores::where(['quiz_id' => $score->quiz_id])->get();
        $quiz = Task::where(['id' => $score->quiz_id])->first();

        if (count($arr) > 0) {
          foreach ($arr as $currentQuiz) {
            if(isset($quiz->id)) {
              if($currentQuiz["quiz_id"] == $quiz->id) {
                $d = "true";
              }
            }
          }
          if ($d != "true" && isset($quiz->id)) {
            $arr[$i] = array("quiz_id" => $quiz->id, "name" => $quiz->name, "quiz_count" => count($quizes));
            $i++;
          }
        } else {
          $arr[$i] = array("quiz_id" => $quiz->id, "name" => $quiz->name, "quiz_count" => count($quizes));
          $i++;
        }
      }
      return view('scores', [
          'quizes' => $arr
      ]);
    }

    public function users()
    {
        return view('users', [
            'users' => User::orderBy('created_at', 'asc')->get()
        ]);
    }

    public function quizPagePas($id)
    {
      $scores = Scores::where(['quiz_id' => $id])->get();
      $arr = [];
      $i = 0;
      foreach ($scores as $score) {
        $user = User::where(['id' => $score->user_id])->first();
        $quiz = Task::where(['id' => $score->quiz_id])->first();
        $arr[$i] = array("name" => $user->name,  "score" => $score->score);
        $i++;
      }
      return view('quiz.pass', [
          'users' => $arr
      ]);
    }
}
