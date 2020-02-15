@extends('layouts.default')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <p>現在のユーザー名: {{Auth::user()->name}}</p>
    <form action="{{ url('/logout') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>

    @foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
    @endforeach

    {{-- 投稿用フォームの作成 --}}
    <form method='post' action="{{ url("/items") }}" enctype="multipart/form-data">
    {{-- csrf対策 --}}
    {{ csrf_field() }}
    <div>
        <label>
            商品名:<br>
            <input type="text" name="name" class="name_field">
        </label>
    </div>

    <div>
        <label>
            価格:<br>
            <input type="text" name="price" class="price_field">
        </label>
    </div>

    <div>
        <label>
            在庫数:<br>
            <input type="text" name="stock" class="stock_field">
        </label>
    </div>

    <div>
        <label>
            画像:<br>
            <input type="file" name="image">
        </label>
    </div>

    <div>
        <lavel>
            ステータス:<br>
            <select name="status">
                <option value = 0>公開</option>
                <option value = 1>未公開</option>
            </select>
        </label>
    </div>

    <div>
        <input type="submit" value="商品追加" class = "btn btn-primary">
    </div>
</form>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>商品画像</th>
                <th>商品名</th> 
                <th>価格</th>
                <th>在庫数</th>
                <th>商品削除</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                @if($item->status === 0)
                <tr>
                    <td>
                        <div class="item__image">
                            @if($item->image !== '')
                                <img src="{{ asset('storage/photos/' . $item->image) }}">
                            @endif
                        </div>
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price) }}円</td> 
                    <td>{{ $item->stock }}</td>
                    <td>
                        <form method="post" action="{{ url('/items/'. $item->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <input type="submit" value="削除"  class = "btn btn-danger delete">
                        </form>
                    </td>
                </tr>
                @endif
            @empty
                <a>商品はありません</a>
            @endforelse
        </tbody>
    </table>
@endsection