<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Task;
use App\Questions;
use App\Answers;

class QuizController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
    return view('tasks', [
        'tasks' => Task::orderBy('created_at', 'asc')->get()
    ]);
  }

  public function showQuestions($id)
  {
    $quiz = Task::find($id);
    $questions = Questions::where('parent_id', $id)->get();
    return view('question.index', ['quiz' => $quiz, 'questions' => $questions]);
  }

  public function showQuestion($parentId, $id)
  {
    $quiz = Task::find($parentId);
    $question = Questions::find($id);
    $answers = Answers::where('parent_id', $id)->get();
    return view('question.show', ['quiz' => $quiz, 'question' => $question, 'answers' => $answers]);
  }

  


}
