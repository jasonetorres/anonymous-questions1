<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'question' => 'required|string|max:255', // Ensure question is required, a string, and max 255 characters
            'name' => 'required|string|max:100', // Ensure name is required, a string, and max 100 characters
        ]);

        try {
            // Log the incoming request data
            Log::info('Request data:', $request->all());

            // Create a new question
            $question = new Question();
            $question->name = $validatedData['name'];
            $question->question = $validatedData['question'];

            // Save the question to the database
            $question->save();

            return response()->json(['message' => 'Your question has been submitted successfully!'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error saving question: ' . $e->getMessage());
            return response()->json(['message' => 'There was an error submitting your question.'], 500);
        }
    }
}
