<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use App\Questions;
use App\Answers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

Route::group(['middleware' => ['web']], function () {
  Route::get('/', ['as' => '/', 'uses' => 'HomeController@index']);
    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/tasks')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/tasks');
    });

    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/tasks');
    });

    Route::get('/quiz/{id}', ['as' => 'questions', 'uses' => 'QuizController@showQuestions']); //Отдельный опросник
    Route::post('/{id}/question/add', function (Request $request) { //Добавление вопроса к опроснику
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/question/'.$request->parent_id)
                ->withInput()
                ->withErrors($validator);
        }

        $question = new Questions;
        $question->parent_id = $request->parent_id;
        $question->name = $request->name;
        $question->type = $request->type;
        $question->save();

        return redirect('/quiz/'.$request->parent_id);
    });
    Route::delete('/{parentId}/question/{id}/delete', function ($parentId, $id) {//Удаление вопроса из опросника
        Questions::where('id', $id)->delete();

        return redirect('/quiz/'.$parentId);
    });
    Route::get('/{parentId}/question/{id}/show', ['as' => 'questions', 'uses' => 'QuizController@showQuestion']);//Отдельный вопрос


    Route::post('/{parentId}/question/{id}/save', function (Request $request) {//Сохранение вопроса
      $question = Questions::find($request->parent_id_question);
      $question->name = $request->name;
      $question->save();
      return redirect($request->parent_id_quiz.'/question/'.$request->parent_id_question.'/show');
    });
    Route::post('/{id}/answer/add', function (Request $request) {//Добавление ответа к вопросу
        $validator = Validator::make($request->all(), [
            'answer' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($request->parent_id_quiz_an.'/question/'.$request->parent_id_question_an.'/show')
                ->withInput()
                ->withErrors($validator);
        }

        $answer = new Answers;
        $answer->parent_id = $request->parent_id_question_an;
        $answer->name = $request->answer;
        $answer->points = $request->points;
        $answer->save();

        return redirect($request->parent_id_quiz_an.'/question/'.$request->parent_id_question_an.'/show');
    });

    Route::delete('/{parentId}/{answerId}/answer/{id}/delete', function ($parentId, $answerId, $id) {//Удаление ответа
      Answers::where('id', $id)->delete();

      return redirect($parentId.'/question/'.$answerId.'/show');
    });

    Route::get('/redirect', ['as' => '/redirect', 'uses' => 'HomeController@redirectToProvider']);
    Route::get('/callback', 'HomeController@handleProviderCallback');

    Route::get('/scores','HomeController@scores');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
    Route::get('/users', 'HomeController@users'); // Таблица с пользователями

    Route::get('/user/quiz/{id}', 'HomeController@showQuiz');
    Route::post('/quiz/{parentId}/question/end', 'HomeController@endQuiz');
    Route::post('/quiz/{parentId}/question/{id}', 'HomeController@nextQuestion');

    Route::get('/quiz/passes/{id}','HomeController@quizPagePas');
    Route::any('/search',function(){
        $q = Input::get ( 'q' );
        $user = User::where('name','LIKE','%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('search')->withDetails($user)->withQuery ( $q );
        else return view ('search')->withMessage('No Details found. Try to search again !');
    });

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/tasks', 'QuizController@index');
});
