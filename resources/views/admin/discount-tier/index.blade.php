<x-admin-master>
    @section('content')
    <div class="card shadow mb-4">
        <a href="#collapseCard" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCard">
            <h4 class="m-0 font-weight-bold text-primary">Add Discount Tier</h4>
        </a>
        @if (Session::has('alert-error'))
          <div class="alert alert-danger">
            {{Session::get('alert-error')}}
          </div>
        @elseif(Session::has('alert-success'))
          <div class="alert alert-success">
            {{Session::get('alert-success')}}
          </div>
        @endif
        <div class="collapse show" id="collapseCard">
            <div class="card-body">
            <form method="POST" action="{{route('discount-tier.store')}}">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="min_amount">Min Amount</label>
                        <input type="number" name="min_amount" class="form-control @error('min_amount') is-invalid @enderror" id="min_amount">

                        @error('min_amount')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-sm-6">        
                        <div class="form-group">
                            <label for="max_amount">Max Amount</label>
                            <input type="number" name="max_amount" class="form-control @error('max_amount') is-invalid @enderror" id="max_amount">

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
                        <input type="number" name="disc_prob" class="form-control @error('disc_prob') is-invalid @enderror" id="disc_prob">
                        
                        @error('disc_prob')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-sm-6">        
                        <div class="form-group">
                            <label for="disc_rate">Discount Rate (%)</label>
                            <input type="number" name="disc_rate" class="form-control @error('disc_rate') is-invalid @enderror" id="disc_rate">

                            @error('disc_rate')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Discount Tiers</h4>
        </div>
        <div class="card-body">
        @if (Session::has('alert-deleted'))
        <div class="alert alert-danger">
          {{Session::get('alert-deleted')}}
        </div>
        @elseif (Session::has('update-success'))
        <div class="alert alert-primary">
          {{Session::get('update-success')}}
        </div>
        @elseif (Session::has('update-error'))
        <div class="alert alert-danger">
          {{Session::get('update-error')}}
        </div>
        @endif
          <div class="table-responsive">
            <table class="table table-bordered" id="table" width="100%" cellspacing="0">
              <thead style="text-align: center">
                <tr>
                    <th>No</th>
                    <th>Min Amount</th>
                    <th>Max Amount</th>
                    <th>Discount Probability</th>
                    <th>Discount Rate</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php $no=0 ?>
                  @foreach ($discountTiers as $data)
                  <?php $no++ ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <td>{{$data->min_amount}}</td>
                      <td>{{$data->max_amount}}</td>
                      <td style="text-align: center">{{$data->discount_probability}}%</td>
                      <td style="text-align: center">{{$data->discount_rate}}%</td>
                      <td>{{date('d M Y H:i', strtotime($data->created_at))}}</td>
                      <td style="text-align: center">
                        <a class="btn btn-warning" href="{{route('discount-tier.edit', $data->id)}}">Edit</a>
                        <a class="btn btn-danger btn-delete" data-delete-link="{{route('dicount-tier.destroy', $data->id)}}" href="#" data-toggle="modal" data-target="#deleteModal">Delete</a>
                      </td>
                    </tr>  
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Delete Modal-->
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete Tier</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Are you sure want to delete this Tier?</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
  
@endsection

@section('scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/datatables.js')}}"></script>

    <script>
        $('.btn-delete').on('click', function () {
            $('#delete-form').attr('action', $(this).data('delete-link'));
        });
    </script>

    @endsection
</x-admin-master>