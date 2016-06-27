<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Redirect;
use App\Http\Requests\JobFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = Job::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
        $title = 'Latest Job Posts';

        return view('home')->withJobs($jobs)->withTitle($title);

    }

    public function create(Request $request)
    {
        if ($request->user()->can_post())
        {
            return view('jobs.create');
        }
        else
        {
            return redirect('/')->withErrors("You dont have permission to write a job post!\n");
        }
    }

    public function store(JobFormRequest $request)
    {
        $job = new Job();
        $job->title = $request->get('title');
        $job->body = $request->get('body');
        $job->slug = str_slug($job->title);
        $job->author_id = $request->user()->id;
        if($request->has('save'))
        {
            $job->active = 0;
            $message = "Job Post saved successfully";
        }
        else
        {
            $job->active = 1;
            $message = "Job Post published Successfully";
        }
        $job->save();
        return redirect('edit/'.$job->slug)->withMessage($message);
    }

    public function show($slug)
    {
        $job = Job::where('slug', $slug)->first();
        if(!$job)
        {
            return redirect('/')->withErrors('requested page not found');
        }
        $comments = $job->comments;
        return view('jobs.show')->withJob($job)->withComments($comments);
    }
//if it has a view its going to grab it and update
    public function edit(Request $request, $slug)
    {
        $job = Job::where('slug', $slug)->first();
        if($job &&($request->user()->id == $job->author_id || $request->user()->is_admin())) 
        {
            return view('jobs.edit')->withJob($job);
        }
        return redirect('/')->withErrors("You cant edit this!");
    }
//checking to see if you are able to update. if you are it gets the title of what you want to update. if it exist it gives
    //error saying it already exist. if not it save it as a draft or the post itself!
    public function update(Request $request)
    {
        $job_id = $request->input('job_id');
        $job = Job::find($job_id);
        if($job &&($request->user()->id == $job->author_id || $request->user()->is_admin())) 
        {
            $title = $request->input('title');
            $slug = str_slug($title);
            $duplicate = Job::where('slug', $slug)->first();
            if($duplicate)
            {
                if($duplicate->id != $job_id)
                {
                    return redirect('edit/'.$job->slug)->withErrors('Title already exist.')->withInput();
                }
                else
                {
                    $job->slug = $slug;
                }
            }
            $job->title = $title;
            $job->body = $request->input('body');
            if($request->has('save'))
            {
                $job->active = 0;
                $message = 'Job Post saved successfully';
                $landing = 'edit/'.$job->slug;
            }
            else
            {
                $job->active = 1;
                $message = "Job Post updated successfully";
                $landing = $job->slug;
            }
            $job->save();
                return redirect($landing)->withMessage($message);
         }
         else
         {
            return redirect('/')->withErrors("You are not allowed to do this!");
         }
    }

    public function destroy(Request $request, $id)
    {
        $job = Job::find($id);
        if($job &&($request->user()->id == $job->author_id || $request->user()->is_admin())) 

        {
            $job->delete();
            $data['message'] = 'Job Post deleted Successfully';
        }
        else
        {
            $data['errors'] = 'You cant delete this job post';
        }
        return redirect('/')->with($data);
    }


}
