<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

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

    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'question' => 'required|string',
            ]);

            // Create a new question
            $question = new Question();
            $question->name = $request->name;
            $question->question = $request->question;

            // Save the question to the database
            $question->save();

            return response()->json(['message' => 'Your question has been submitted successfully!'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving question: ' . $e->getMessage());
            return response()->json(['message' => 'There was an error submitting your question.'], 500);
        }
    }
}
