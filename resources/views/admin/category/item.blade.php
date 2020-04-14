<li>
    <input type="checkbox" name="categories" class="custom-control-input messageCheckbox"
           id="checkbox.{{$category->id}}" value="{{ $category->id }}"
   
    >
    <label class="custom-control-label" for="checkbox.{{$category->id}}">  {{ $category->title }}</label>
    @if(isset($categories[$category->id]))
        @include('admin.category.list',['items' =>$categories[$category->id] ])
    @endif
</li>

