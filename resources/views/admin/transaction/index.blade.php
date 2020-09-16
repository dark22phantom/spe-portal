<x-admin-master>
    @section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Submit Transaction</h4>
        </div>
        @if (Session::has('alert-api'))
          <div class="alert alert-danger">
            {{Session::get('alert-api')}}
          </div>
        @elseif(Session::has('success-api'))
          <div class="alert alert-success">
            {{Session::get('success-api')}}
          </div>
        @endif
        <div class="card-body">
          <form method="post" action="{{route('transaction.store')}}">
            @csrf
            <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                      <label for="customer">Customer</label>
                      <select name="customer" class="form-control @error('customer') is-invalid @enderror" id="customer">
                        <option value="0">-- Choose Customer --</option>
                        @foreach ($customers as $customer)
                          <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                      </select>

                      @error('customer')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                  </div>
                </div>
                <div class="col-sm-5">        
                  <div class="form-group">
                      <label for="transaction_amount">Transaction Amount</label>
                      <input type="number" name="transaction_amount" class="form-control @error('transaction_amount') is-invalid @enderror" id="transaction_amount">

                      @error('transaction_amount')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="transaction_amount" style="color: transparent">Submit Transaction</label>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
            </div>
          </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Transaction History</h4>
        </div>
        @if (Session::has('alert-deleted'))
        <div class="alert alert-danger">
          {{Session::get('alert-deleted')}}
        </div>
        @endif
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table" width="100%" cellspacing="0">
              <thead style="text-align: center">
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Transaction Amount</th>
                    <th>Get Discount</th>
                    <th>Discount Rate</th>
                    <th>Discount Amount</th>
                    <th>Payment Amount</th>
                    <th>Transaction Date</th>
                </tr>
              </thead>
              <tbody>
                  <?php $no=0 ?>
                  @foreach ($transactions as $transaction)
                  <?php $no++ ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <td>{{$transaction->name}}</td>
                      <td>{{$transaction->transaction_amount}}</td>
                      <td style="text-align: center">{{$transaction->discount_bool == 1 ? 'Yes' : 'No'}}</td>
                      <td style="text-align: center">{{$transaction->discount_rate}}%</td>
                      <td>{{$transaction->discount_amount}}</td>
                      <td>{{$transaction->payment_amount}}</td>
                      <td>{{date('d M Y H:i', strtotime($transaction->created_at))}}</td>
                    </tr>  
                  @endforeach
              </tbody>
            </table>
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
    @endsection
</x-admin-master>