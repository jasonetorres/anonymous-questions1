<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Ensure you import the Question model

class QuestionController extends Controller
{
    public function index()
    {
        // Fetch all questions from the database
        $questions = Question::all();
        return view('admin', compact('questions'));
    }

    public function destroy($id)
    {
        // Find the question by ID and delete it
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully.']);
    }

    public function submit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'question' => 'required|string|max:1000',
        ]);

        // Process the data (e.g., save to the database)
        // Example: Question::create($request->all());

        // Return a response
        return response()->json(['message' => 'Your question has been submitted successfully!']);
    }
}
