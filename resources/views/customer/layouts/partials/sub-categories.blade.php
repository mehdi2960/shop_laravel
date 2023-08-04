<section class="sidebar-nav-sub-wrapper py-1 px-2">
    <section class="sidebar-nav-sub-item">
        @foreach($categories as $category)
            <span class="sidebar-nav-sub-item-title">
            <a href="{{route('customer.products')}}" class="d-inline">{{$category->name}}</a>
                 @if($category->children->count()>0)
                    <i class="fa fa-angle-left"></i>
                @endif
        </span>
            @include('customer.layouts.partials.sub-categories',['categories'=>$category->children])
        @endforeach
    </section>
</section>
