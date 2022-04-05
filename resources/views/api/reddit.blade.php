@foreach ($response->data->children as $item)
  <div>
    <h3>
      {{ $item->data->title }}
    </h3>
    <p>
      {{ $item->data->selftext }}
    </p>
  </div>
@endforeach