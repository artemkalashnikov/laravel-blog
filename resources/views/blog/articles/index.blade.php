<table>
    @foreach($paginator as $blogItem)
        <tr>
            <td>{{ $blogItem->id }}</td>
            <td>{{ $blogItem->title }}</td>
            <td>{{ $blogItem->created_at }}</td>
        </tr>
    @endforeach
</table>
<div>
    @if($paginator->total() > $paginator->count())
        {{$paginator->links()}}
    @endif
</div>
