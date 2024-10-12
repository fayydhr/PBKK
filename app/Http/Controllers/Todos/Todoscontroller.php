<?php

namespace App\Http\Controllers\Todos;

use App\Http\Controllers\Controller;
use App\Models\Todos;
use App\Models\Category; // Import Category model
use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all(); // Get all categories
        $query = Todos::with('category'); // Eager load category
    
        // Check if a category is selected for filtering
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
    
        $todos = $query->get(); // Get the filtered todos
    
        return view('todo.app', compact('todos', 'categories')); // Pass todos and categories to view
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('todo.create', compact('categories')); // Pass categories to create view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|min:3',
            'category_id' => 'required|exists:categories,id', // Validate category_id
        ]);

        Todos::create($request->only(['task', 'category_id']));
        return redirect('/todo')->with('success', 'Complete data saving');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todos::with('category')->findOrFail($id); // Get the todo with its category
        return view('todo.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = Todos::findOrFail($id); // Get the todo to edit
        $categories = Category::all(); // Get all categories
        return view('todo.edit', compact('todo', 'categories')); // Pass todo and categories to edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required|min:3',
            'is_done' => 'required|boolean',
        ]);

        $todo = Todos::findOrFail($id);
        $todo->update($request->only(['task', 'is_done']));
        
        return redirect('/todo')->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todos::find($id);
    
        if (!$todo) {
            return redirect('/todo')->with('error', 'Todo not found');
        }
    
        $todo->delete();
        return redirect('/todo')->with('success', 'Todo deleted successfully');
    }
}
