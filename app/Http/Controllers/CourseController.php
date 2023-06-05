<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
       $courses = Course::all();
        return view('course.index', compact('courses'));
    }

    public function create()
    {
        $lecturers = Lecturer::all();
        $classes = Classe::all();
        return view('course.create', compact('classes', 'lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:courses'],
            'short_name' => ['required', 'string', 'min:3', 'max:255'],
            'max_mark' => ['required', 'integer'],
        ]);

        $number = Str::random('2') . '-' . rand('30', '90') . rand('100', '200');
        $name = htmlspecialchars($request->name);
        $slug_name = Str::slug($name);
        $short_name = htmlspecialchars($request->short_name);
        $max_mark = htmlspecialchars($request->max_mark);

        $course = Course::firstOrCreate([
            'course_number' => $number,
            'name' => $name,  
            'slug_name' => $slug_name,   
            'short_name' => $short_name,
            'max_mark' => $max_mark,
            'lecturer_id' => $request->lecturer,
            'classe_id' => $request->classe,
        ]);

        if($course){
            session()->flash('message', 'Cours crée avec succès');
            return redirect(route('course.index'));
        }
    }
  
    public function show(course $course)
    {
        return view('course.show', compact('course'));
    }

    public function edit(course $course)
    {
        $lecturers = Lecturer::all();
        $classes = Classe::all();
        return view('course.edit', compact('course', 'lecturers', 'classes'));
    }
    
    public function update(Request $request, course $course)
    {
        if($course)
        {
            $request->validate([
                'name' => ['required', 'string', 'min:5', 'max:255'],
                'short_name' => ['required', 'string', 'min:3', 'max:255'],
                'max_mark' => ['required', 'integer'],
            ]);

            $name = htmlspecialchars($request->name);
            $slug_name = Str::slug($name);
            $short_name = htmlspecialchars($request->short_name);
            $max_mark = htmlspecialchars($request->max_mark);

            $course->update([
                'name' => $name,  
                'slug_name' => $slug_name,   
                'short_name' => $short_name,
                'max_mark' => $max_mark,
                'lecturer_id' => $request->lecturer,
                'classe_id' => $request->classe,
            ]);
        
            session()->flash('message', 'Cours modifié avec succès');
            return redirect(route('course.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(course $course)
    {
        if($course)
        {
            if($course->marks)
            {
                $course->marks->delete();
            }

            $course->delete();

            session()->flash('message', "Cours supprimée avec succès");
            return redirect()->route('course.index');
        }
    }
}
