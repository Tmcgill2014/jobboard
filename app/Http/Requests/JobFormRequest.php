<?

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Authh;

class JobFormRequest extends Request{

	public function authorize()
	{
		//This is the post form request, brings back a user and then we are checking if the user can post and then return a boolean!
		if($this->user()->can_post())
		{
			return true;
		}
		return false;
	}

	public function rules()
	{
		return [
			'title' => 'required|unique:posts|max:225',
			'body' => 'required',
		];
	}

}