<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(){
        if(Auth::User()->authority != 1){
            return redirect()->route('Profile.show', [
                'user' => Auth()->User()->id,
            ])->withErrors(['error' => 'You have no access to see this page']); 
        }else{
            $Notes_Amount = $this->getdata_Notes_Amount();
            $Notes = $this->getdata_Notes();
            $Users = $this->getdata_Users();
            $Users_History = $this->getdata_Users_History();
            $Notes_History = $this->getdata_Notes_History();

            return  view('Admin', compact([
                'Notes_Amount',
                'Notes',
                'Users',
                'Users_History',
                'Notes_History',
                ]))->with('success', 'Welcome to Admin-Page!!');
        }
    }

    public function getdata_Notes_Amount(){
        $month = (int)date("m");

        if($month > 4){
            $Notes_Amount = [
                DB::table('notes')->whereMonth('created_at', (string)('0'.$month - 4))->count(),

                DB::table('notes')->whereMonth('created_at',  (string)('0'.$month - 3))->count(),

                DB::table('notes')->whereMonth('created_at',  $month - 2 >= 10?(string)($month - 2):(string)('0'.$month - 2))->count(),

                DB::table('notes')->whereMonth('created_at',  $month - 1 >= 10?(string)($month - 1):(string)('0'.$month - 1))->count(),

                DB::table('notes')->whereMonth('created_at',  (string)$month)->count(),
            ];    
        }else{
            $year = date("y");

            $Notes_Amount = [
                DB::table('notes')->whereYear('created_at', '=', $month - 4 <= 0?(string)($year - 1):(string)$year)
                ->whereMonth('created_at', '=', 16 - $month >= 10?(string)(16 - $month):(string)('0'.(16 - $month)))->count(),

                DB::table('notes')->whereYear('created_at', '=', $month - 4 <= 0?(string)($year - 1):(string)$year)
                ->whereMonth('created_at', '=', $month - 3 <= 0?(15 - $month >= 10?(string)(15 - $month):(string)('0'.(15-$month))):(string)$month)->count(),

                DB::table('notes')->whereYear('created_at', '=', $month - 4 <= 0?$year - 1:$year)
                ->whereMonth('created_at', '=', $month - 2 <= 0?(14 - $month >= 10?(string)(14 - $month):(string)('0'.(14-$month))):(string)$month)->count(),

                DB::table('notes')->whereYear('created_at', '=', $month - 4 <= 0?(string)($year - 1):(string)$year)
                ->whereMonth('created_at', '=', $month - 1 <= 0?(13 - $month >= 10?(string)(13 - $month):(string)('0'.(13-$month))):(string)$month)->count(),

                DB::table('notes')->whereMonth('created_at', '=', (string)$month)->count(),
            ];
        }

        return $Notes_Amount;
    }

    public function getdata_Notes(){
        $Notes = DB::table('notes')->orderBy('id', 'asc')->latest()->paginate(5);

        return $Notes;
    }

    public function getdata_Users(){
        $Notes = DB::table('users')->orderBy('id', 'asc')->latest()->paginate(5);

        return $Notes;
    }

    public function getdata_Users_History(){
        $Users_History = DB::table('user_History')->orderBy('created_at', 'desc')->paginate(5);

        return $Users_History;
    }

    public function getdata_Notes_History(){
        $Users_History = DB::table('notes_History')->orderBy('created_at', 'desc')->paginate(5);

        return $Users_History;
    }

}
