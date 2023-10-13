<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\Resource;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{

    public function index($id)
    {
        $activ = Activity::join('stages', 'stages.id', '=', 'activities.stage_id')
            ->join('activity_project', 'activity_project.activity_id', '=', 'activities.id')
            ->select(
                'activities.name as actividad',
                'activity_project.start_date',
                'activity_project.expected_date',
                'activity_project.true_start',
                'activity_project.end_date',
                'activity_project.status',
                'stages.name as etapa'
            )
            ->where("activity_project.id", $id)
            ->get();

        $comments = Comment::join('activity_project', 'activity_project.id', '=', 'comments.activity_project_id')
            ->join('users', 'users.id', '=', 'comments.user_id')            
            ->select('comments.id as id', 'comments.body', 'comments.created_at', 'comments.updated_at', 'users.name')
            ->where("comments.activity_project_id", "=", $id)
            ->orderby('comments.created_at', 'desc')
            ->get();      
        
        $resources = Resource::all();                

        return response()->json(['comments' => $comments, 'resources' => $resources, 'activity' => $activ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comentario'   => 'required',
        ]);

        $comment = Comment::create([
            'body'                  => $request->comentario,
            'user_id'               => auth()->user()->id,
            'activity_project_id'   => (int)$request->taskId,
        ]);

        if ($request->file('recurso')) {
            $file = $request->file('recurso');
            $name = $file->getClientOriginalName();
            $valor = Storage::putFileAs('public/comments', $file, $name);            
            $url = str_replace('public/','storage/',$valor);  

            $comment->resources()->create([
                'url'   => $url
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $resource = '';
        $filename = '';
        $comment = Comment::find($id);

        if (isset($comment->resources[0]->url)) {
            $resource = asset($comment->resources[0]->url);  
            $filename = str_replace('storage/comments/','',$comment->resources[0]->url); 
        }
       
        return response()->json(['success' => $comment, 'resource' => $resource, 'filename' => $filename]);
    }
   

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comentario'   => 'required',
        ]);

        $comment->update([
            'body' => $request->comentario
        ]);

        /*if ($request->file('recurso')) {

            $url = $request->file('recurso')->store('public/comments');

            $comment->resources()->update([
                'url'   => $url
            ]);
        }*/

        return response()->json(['data' => 'Comentario actualizado']);
    }
}
