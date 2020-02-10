<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(){
        $title = '商品管理画面';

        $items = \App\item::all();

        return view('items.index',[
            'title' => $title,
            'items' => $items,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:20',
            'price' => 'required|max:1000000|numeric',
            'stock' => 'required|max:10000|numeric',
            'image' => [
                'file',
                'image',
                'mimes:jpeg,png',
                'max:100',
            ], 
            
        ]); 

        $filename = '';
        $image = $request->file('image');
        if( isset($image) === true ){
            // 拡張子を取得
            $ext = $image->guessExtension();
            // アップロードファイル名は [ランダム文字列20文字].[拡張子]
            $filename = str_random(20) . ".{$ext}";
            // publicディスク(storage/app/public/)のphotosディレクトリに保存
            $path = $image->storeAs('photos', $filename, 'public');
        }

        $item = new \App\item;

        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->image = $filename;
        $item->status = $request->status;

        $item->save();

        return redirect('items');
    }
    
    public function destroy($id){
        $item = \App\item::find($id);
        $item->delete();

        return redirect('items');
    }
}
