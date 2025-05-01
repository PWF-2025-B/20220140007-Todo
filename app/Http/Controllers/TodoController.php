<?php

namespace App\Http\Controllers;


use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        // $todos = Todo.all();
        $todos = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        // dd($todos);
        $todosCompleted = Todo::where('user_id', Auth::id())
             ->where('is_done', true)
             ->count();
 
 
         return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function create()
    {
        return view('todo.create');
    }

    public function edit(Todo $todo)
    {
        if (Auth::id() == $todo->user_id) {
            return view('todo.edit', compact('todo'));
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Todo::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'is_done' => false,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully!');
    }

    public function complete(Todo $todo)
     {
         if (Auth::id() == $todo->user_id) {
             $todo->update([
                 'is_done' => true,
             ]);
             return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
         } else {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
         }
     }

     public function uncomplete(Todo $todo)
     {
         if (Auth::id() == $todo->user_id) {
 
             $todo->update([
                 'is_done' => false,
             ]);
             return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
         } else {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
         }
     }
 
     public function update(Request $request, Todo $todo)
     {
         // Tambahkan pengecekan user_id dulu
         if (Auth::id() !== $todo->user_id) {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to update this todo!');
         }
 
         // Kalau lolos, lanjut validasi
         $validated = $request->validate([
             'title' => 'required|string|max:255',
         ]);
 
         // Update todo
         $todo->update([
             'title' => ucfirst($validated['title']),
         ]);
 
         return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
     }
 
     public function destroy(Todo $todo)
     {
         if (Auth::id() == $todo->user_id) {
             $todo->delete();
             return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
         } else {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
         }
     }
     public function destroyCompleted()
     {
         // get all todos for current user where is_completed is true
         $todosCompleted = Todo::where('user_id', Auth::id())
             ->where('is_done', true)
             ->get();
         foreach ($todosCompleted as $todo) {
             $todo->delete();
         }
         // dd($todosCompleted);
         return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
     }
}