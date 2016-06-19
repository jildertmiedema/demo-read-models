<h3><a href="{{$link}}"><i class="fa fa-cube"></i>  {{$product->name}}</a></h3>
{{$product->name}} - <i>{{ money($product->price) }}</i><br>
{{Str::limit($product->description, 100)}}<br>