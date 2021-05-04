<div class="form-group">
    <label>Select Category Lavel</label>
    <select class="form-control select2" style="width: 100%;" name="parent_id">
        <option @if (empty($categoryData))
        selected="selected"
        @endif  value="0" @if (isset($categoryData->parent_id)&& $categoryData->parent_id==0)
           selected 
        @endif>Main Category</option>
        @if (!empty($getCategories))
            @foreach ($getCategories as $category)
                <option value="{{$category['id']}}" @if (isset($categoryData->parent_id)&& $categoryData->parent_id==$category->id)
                    selected
                @endif>{{$category['category_name']}}</option>
                @if (!empty($category['childcategories']))
                    @foreach ($category['childcategories'] as $child)
                        <option value="{{$child['id']}}">&#10146;&#10146; {{$child['category_name']}}</option>
                    @endforeach    
                @endif
            @endforeach
        @endif
    </select>
  </div>