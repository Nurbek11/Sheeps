<?php

namespace App\Http\Controllers;

use App\Sheep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SheepController extends Controller
{

    public function index()

    {
        $sheepfold = [1, 1, 1, 1];
        $count = count($sheepfold);    //4
        $total = 10 - $count;    //6


        if (Sheep::isSheepfoldEmpty()) {
            DB::beginTransaction();

            while ($total > 0) {
                $number = mt_rand(0, 3);//random number between 0 and 4
                $sheepfold[$number] = $sheepfold[$number] + 1;
                $total = $total - 1;
            }

            foreach ($sheepfold as $key => $value) {
                for ($i = 1; $i <= $value; $i++) {
                    Sheep::add($key + 1);
                }
            }
            DB::commit();
        }

        $all = DB::table('sheep')->where('active', 1)->orderBy('sheepfold')->get();
        $sheepfold = [];
        foreach ($all as $sheep) {
            $sheepfold[$sheep->sheepfold][] = $sheep->id;


        }
        return view('welcome', ['sheepfold' => $sheepfold, 'all' => $all]);

    }
    public function breed()
    {
        $padList = [1, 2, 3, 4];
        $randomList = [];
        foreach ($padList as $sheepfold) {
            $total = DB::table('sheep')->where([['sheepfold', '=', $sheepfold], ['active', '=', '1']])->count();

            if ($total >= Sheep::NumberToBreeding) {
                $randomList[] = $sheepfold;
            }
        }

        $count = count($randomList);
        $msg = json_encode(0);

        if ($count > 0) {
            $index = (mt_rand(Sheep::MinSheepfold, count($randomList)) - 1);

            $id = Sheep::add($randomList[$index]);
            $msg = json_encode(['sheepfold' => $randomList[$index], 'sheep_id' => $id]);
        }

        echo $msg;
    }
    public function statistics()
    {
        $total = DB::table('sheep')->latest()->count();
        $live = DB::table('sheep')->where('active', 1)->latest()->count();
        $euthanized = DB::table('sheep')->where('active', 0)->latest()->count();

        $min = DB::table('sheep')->select('sheepfold', DB::raw('COUNT(id) as total'))->groupBy('sheepfold')->orderBy('total')->first();
        $max = DB::table('sheep')->select('sheepfold', DB::raw('COUNT(id) as total'))->groupBy('sheepfold')->orderBy('total', 'desc')->first();

        return view('statistics', ['all' => $total, 'live' => $live, 'sleep' => $euthanized, 'min' => $min, 'max' => $max]);
    }
    public function sleep()
    {
        $id = Sheep::euthanize();
        $moved = Sheep::checkSheepfold();

        $msg = ['sleep' => ['id' => $id], 'moved' => $moved];

        echo json_encode($msg);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
