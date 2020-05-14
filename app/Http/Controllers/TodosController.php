<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\TodoFormRequest;
use App\Todo;

class TodosController extends Controller
{

    /**
     * Used to get all todos
     * @get ("/api/todo")
     * @return Response
     */

    public function index()
    {
        $todos = Todo::latest()->get();
        return $this->sendSuccess($todos, 'List of todos');
    }

    /**
     * Used to create Task
     * @post ("/api/todo/store")
     * @param ({
     *      @Parameter("task", type="string", required="true", description="Title of task"),
     *      @Parameter("description", type="string", required="false", description="Short Explanation of Task"),
     * })
     * @return created task
     */
    public function store(TodoFormRequest $request)
    {
        // The incoming request is valid...
        // Retrieve the validated input data...
        $validated = $request->validated();

        $todo = new Todo();
        $todo->task = $validated['task'];
        $todo->is_completed  = $validated['is_completed'];
        $todo->save();

        if (!$todo) {
            return $this->sendError('Unable to save the task');
        }

        return $this->sendSuccess($todo, 'Task Created Successfully');
    }
    /**
     * Used to update Task
     * @patch ("/api/todo/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Task"),
     *      @Parameter("task", type="string", required="true", description="Title of task"),
     *      @Parameter("description", type="text", required="optional", description="Description of Todo")
     * })
     * @return Response
     */
    public function update($id, TodoFormRequest $request)
    {
        //validate data
        $validated = $request->validated();
        $todo = Todo::findOrFail($id);
        $todo->task = $validated['task'];
        $todo->is_completed = $validated['is_completed'];
        $todo->save();

        if (!$todo) {
            return $this->sendError('Unable to save the task');
        }

        return $this->sendSuccess($todo, 'Task Updated Successfully');
    }

    /**
     * Used to get Task detail
     * @get ("/api/todo/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Task"),
     * })
     * @return Response
     */

    public function show($id)
    {
        $todo = TOdo::whereId($id)->first();

        if ($todo) {
            return   $this->sendSuccess($todo, 'Task detail');
        } else {
            return  $this->sendError('Unable to show task detail');
        }
    }

    /**
     * Used to delete Task
     * @delete ("/api/todo/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Task"),
     * })
     * @return Response
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        if ($todo) {
            return $this->sendSuccess($todo, 'Task deleted successfully');
        } else {
            return $this->sendError('Error Occurred when deleting the task');
        }
    }
}
