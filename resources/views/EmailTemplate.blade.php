<link href="{{ asset('css/app.css') }}" rel="stylesheet">



 <div>
        <div className="primary-frame product-card-frame">
               <br>
                Dear Customer,
                <br>
                We are pleased to share the detailed product Catelogue of your requested product.
                <br>

                The details of the product you choosed is as below:
       
       

        <div class='text-wrap'>
          <h1>{{$mailRequest1->title}}</h1>
      
          <h2><span class='price'>Price: &nbsp;</span>₹ {{ $mailRequest1->price}} <span className='vat'>Excluding VAT</span></h2>
          <h4><u>Product Description:</u></h4>
          <p>{{ $mailRequest1->description}}</p>
        </div>
        
        <br>
        Please Find the Detailed Product Catelogue attached as pdf file below.
<br>
<br>
       
       
        Thank You,
<br>
<br>
        Tranetech Software Solutions pvt. ltd.
<br>
<br>
      </div>
       
</div>


