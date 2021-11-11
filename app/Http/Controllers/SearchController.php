<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    function search(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('users')
                    ->where('name', 'LIKE', '%'.$query.'%')
                    ->orWhere('email', 'LIKE', '%'.$query.'%')
                    ->orWhere('phone_number', 'LIKE', '%'.$query.'%')
                    ->get();

            }
            else
            {
                $data = DB::table('users')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    if($row->email_verified_at != null) {
                        $output .= '
                        <tr>
                         <th scope="row">#'.$row->id.'</>
                         <td>'.$row->name.'</td>
                         <td>'.$row->email.'</td>
                         <td>'.$row->phone_number.'</td>
                         <td>
                            <a href="/edit-user-view/'.$row->id.'" class="btn btn-primary" title="Edit">
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="'.$row->id.'">Delete</button>
                            <button type="button" class="btn btn-warning unverify" data-id="'.$row->id.'">Unverify</button>
                        </td>
                        <td><center><span class="badge badge-success">Yes</span></center></td>
                        </tr>
                    ';
                    } else {
                        $output .= '
                        <tr>
                         <th scope="row">#'.$row->id.'</>
                         <td>'.$row->name.'</td>
                         <td>'.$row->email.'</td>
                         <td>'.$row->phone_number.'</td>
                         <td>
                            <a href="/edit-user-view/'.$row->id.'" class="btn btn-primary" title="Edit">
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger delete" data-id="'.$row->id.'">Delete</button>
                            <button type="button" class="btn btn-warning unverify" data-id="'.$row->id.'">Unverify</button>
                        </td>
                        <td><center><span class="badge badge-danger">No</span></center></td>
                        </tr>
                    ';
                    }
                }
            } else {
                $output = '
                   <tr>
                    <td align="center" colspan="5">No Users Found</td>
                   </tr>
                ';
            }

            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
