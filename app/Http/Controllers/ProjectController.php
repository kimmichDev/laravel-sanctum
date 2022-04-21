<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "duration" => "required"
        ]);
        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->student_id = auth()->user()->id;
        $project->duration = $request->duration;
        $project->save();
        return response()->json([
            "status" => "ok",
            "message" => "Create project successfully",
            "data" => $project
        ]);
    }
}
