@extends('front.layouts.master')
@section('content')

<body>


   

    <!-- Start Shop Page  -->
    <div class="shop-box-inner">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">
                    <div class="product-categori">
                        
                        <div class="filter-sidebar-left">
                            <div class="title-left">
                                <h3>Categories</h3>
                            </div>
                            <div class="list-group list-group-collapse list-group-sm list-group-tree" id="list-group-men" data-children=".sub-men">
                                @foreach($categories as $cat)
                                <div class="list-group-collapse sub-men">
                                    <a class="list-group-item list-group-item-action" href="#{{$cat->id}}" data-toggle="collapse" aria-expanded="true" aria-controls="sub-men1">{{$cat->name}} <small class="text-muted"></small>
                                </a>
                                    <div class="collapse show" id="{{$cat->id}}" data-parent="#list-group-men">
                                        <div class="list-group">
                                            @foreach($cat->categories as $subcat)
                                            <a href="{{url('/categories/'.$subcat->id)}}" class="list-group-item list-group-item-action active">{{$subcat->name}} </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                               
                            </div>
                        </div>
                       

                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                    <div class="right-product-box">
                        

                        <div class="row product-categorie-box">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
                                    <div class="row">
                                        @foreach($products as $product)
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            <div class="products-single fix">
                                                <div class="box-img-hover">
                                                    <div class="type-lb">
                                                        <p class="sale">Sale</p>
                                                    </div>
                                                    <img src="uploads/products/{{$product->image}}" class="img-fluid" alt="Image">
                                                    <div class="mask-icon">
                                                        <ul>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                        </ul>
                                                        <a class="cart" href="#">Detail Page</a>
                                                    </div>
                                                </div>
                                                <div class="why-text">
                                                    <h4>{{$product->description}}</h4>
                                                    <h5>{{$product->price}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        {{$products->links()}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Shop Page -->

   
</body>

@endsection