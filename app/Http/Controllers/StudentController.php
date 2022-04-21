<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "age" => "required|integer|min:18",
            "email" => "required|email|unique:students,email",
            "password" => "required|min:4",
            "phone_no" => "required"
        ]);
        $student = new Student();
        $student->name = $request->name;
        $student->age = $request->age;
        $student->email = $request->email;
        $student->phone_no = $request->phone_no;
        $student->password = Hash::make($request->password);
        $student->save();
        return response()->json([
            "status" => "ok",
            "message" => "created student successfully",
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        $student = Student::where("email", $request->email)->first();
        if (is_null($student)) {
            return response()->json([
                "status" => "error",
                "message" => "No student with such email",
            ], 404);
        };
        if (!Hash::check($request->password, $student->password)) {
            return response()->json([
                "status" => "error",
                "message" => "Wrong password",
            ], 403);
        };
        $token = $student->createToken("auth-token");
        return response()->json([
            "status" => "ok",
            "message" => "Login success fully",
            "data" => $token
        ]);
    }

    public function profile()
    {
        return response()->json([
            "status" => "ok",
            "message" => "Student profile information",
            "data" => Auth::user(),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => "ok",
            "message" => "Logout success fully",
        ]);
    }
};
