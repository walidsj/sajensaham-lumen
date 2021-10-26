<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Packet;
use Illuminate\Http\Request;

/** 
 *? Naming convention: index [GET], show [GET], store [POST], update [PUT], destroy [DELETE]
 *  https://stackoverflow.com/questions/59014483/laravel-best-naming-convention-for-controller-method-and-route
 */

class CourseController extends Controller
{
    /**
     ** Retrieve all of data courses.
     * 
     * @return void
     */

    public function index()
    {
        $courses = Course::withCount(['packets', 'sales'])->with(['packets' => function ($query) {
            $query->orderBy('packets.price', 'asc');
        }])->get();

        return response()->json([
            'message' => 'Courses found.',
            'data' => $courses
        ]);
    }

    /**
     ** Get an course data.
     * 
     * @param id
     * @return void
     */

    public function show($course_id)
    {
        $course = Course::findOrFail($course_id);

        return response()->json([
            'message' => 'A course found.',
            'data' => $course
        ]);
    }

    /**
     ** Add an new course.
     * 
     * @return void
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'in:active,inactive'
        ]);

        $course = Course::create($request->all());

        return response()->json([
            'message' => 'Course successfully added.',
            'data' => $course
        ]);
    }

    /**
     ** Update an new course.
     * 
     * @return void
     */

    public function update(Request $request, $course_id)
    {
        $this->validate($request, [
            'title' => 'max:255',
            'description' => 'min:8',
            'status' => 'in:active,inactive'
        ]);

        $course = Course::findOrFail($course_id);
        $course->update($request->all());

        return response()->json([
            'message' => 'Course successfully updated.',
            'data' => $course
        ]);
    }

    /**
     ** Destroy an course data.
     * 
     * @param id
     * @return void
     */

    public function destroy($course_id)
    {
        $course = Course::findOrFail($course_id);
        $course->delete($course_id);

        return response()->json([
            'message' => 'Course successfully deleted.',
            'data' => $course
        ]);
    }

    /** ====================================================
     ** Addition for packets.
     *  Follow best practice of API routes.
     *  ================================================= */

    /**
     ** Get an course data.
     * 
     * @param id
     * @return void
     */

    public function getAllPackets($course_id)
    {
        $packets = Packet::where('course_id', $course_id)->get();

        return response()->json([
            'message' => 'Packets found.',
            'data' => $packets
        ]);
    }

    public function getPacket($course_id, $packet_id)
    {
        $packets = Packet::where('course_id', $course_id)->where('id', $packet_id)->first();

        return response()->json([
            'message' => 'Packet found.',
            'data' => $packets
        ]);
    }
}
