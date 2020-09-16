<x-admin-master>
    @section('content')
    <div class="card shadow mb-4">
        <a href="#collapseCard" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCard">
            <h4 class="m-0 font-weight-bold text-primary">Edit Discount Tier</h4>
        </a>
        <div class="collapse show" id="collapseCard">
            <div class="card-body">
            <form method="POST" action="{{route('discount-tier.update', $data->id)}}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="min_amount">Min Amount</label>
                        <input type="number" name="min_amount" class="form-control @error('min_amount') is-invalid @enderror" id="min_amount" value={{$data->min_amount}}>

                        @error('min_amount')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-sm-6">        
                        <div class="form-group">
                            <label for="max_amount">Max Amount</label>
                            <input type="number" name="max_amount" class="form-control @error('max_amount') is-invalid @enderror" id="max_amount" value={{$data->max_amount}}>

                            @error('max_amount')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="disc_prob">Discount Probability (%)</label>
                        <input type="number" name="disc_prob" class="form-control @error('disc_prob') is-invalid @enderror" id="disc_prob" value={{$data->discount_probability}}>
                        
                        @error('disc_prob')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-sm-6">        
                        <div class="form-group">
                            <label for="disc_rate">Discount Rate (%)</label>
                            <input type="number" name="disc_rate" class="form-control @error('disc_rate') is-invalid @enderror" id="disc_rate" value={{$data->discount_rate}}>

                            @error('disc_rate')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a class="btn btn-danger" href="{{route('discount-tier.index')}}">Cancel</a>
                    </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    @endsection
</x-admin-master>