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

    public function index()
    {
        $projects = Project::where("student_id", auth()->user()->id)->get();
        return response()->json([
            "status" => "ok",
            "message" => "Project list",
            "data" => $projects
        ]);
    }

    public function show($id)
    {
        $project = Project::find($id);
        if (is_null($project)) {
            return response()->json([
                "status" => "error",
                "message" => "No project with this id existed"
            ], 404);
        }
        if ($project->student_id !== auth()->user()->id) {
            return response()->json([
                "status" => "error",
                "message" => "Not your project"
            ], 403);
        }
        return response()->json([
            "status" => "ok",
            "message" => "Project Found",
            "data" => $project
        ], 200);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if (is_null($project)) {
            return response()->json([
                "status" => "error",
                "message" => "No project with this id existed"
            ], 404);
        };
        if ($project->student_id !== auth()->user()->id) {
            return response()->json([
                "status" => "error",
                "message" => "Not your project"
            ], 403);
        };
        $project->delete();
        return response()->json([
            "status" => "ok",
            "message" => "Project deleted"
        ], 200);
    }
}
