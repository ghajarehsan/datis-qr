<style type="text/css">

    .container {
        display: flex;
        justify-content: center;

    }

    .product {
        width: 80%;
        display: flex;
        justify-content: space-between;
    }

    .product > div {
        border: 1px solid #cce3f6;
        padding: 15px;
        border-radius: 10px;
    }

    .button {
        background: green;
        padding: 5px 10px;
        color: white;
        border-radius: 10px;
    }

</style>

<div class="container">

    <div class="product">
        @foreach($products as $key=>$row)
            <div>
                <div style="margin-bottom: 20px">product1</div>
                <div>
                    2000
                </div>
                <div>
                    <a href="{{route('basket.add',['product'=>$row->id])}}" class="button">
                        add to basket
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
