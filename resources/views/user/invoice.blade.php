@extends('layout.user')

@push('header')
@endpush

@section('main')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Extra Pages</a>
                            </li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Invoice</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo & title -->
                        <div class="clearfix">
                            <div class="float-start">
                                <div class="auth-brand">
                                    <div class="logo logo-dark">
                                        <span class="logo-lg">
                                            <img src="{{ asset('images/logo-dark.png') }}" alt=""
                                                height="22">
                                        </span>
                                    </div>

                                    <div class="logo logo-light">
                                        <span class="logo-lg">
                                            <img src="{{ asset('images/logo-light.png') }}" alt=""
                                                height="22">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <h4 class="m-0 d-print-none">Invoice</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <p><b>Hello, {{ Auth::user()->name }}</b></p>
                                    <p class="text-muted">Thanks a lot because you keep purchasing our
                                        products. Our company
                                        promises to provide high quality products for you as well as
                                        outstanding
                                        customer service for every transaction. </p>
                                </div>

                            </div><!-- end col -->
                            <div class="col-md-4 offset-md-2">
                                <div class="mt-3 float-end">
                                    <p><strong>Order Date : </strong> 
                                        <span class="float-end">
                                            {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d F Y') }}
                                        </span>
                                     </p>                                     
                                    <p><strong>Order Status :   &nbsp;</strong> <span class="float-end"><span
                                                class="badge bg-danger">{{ $pesanan->status }}</span></span></p>
                                    <p><strong>Order No. : </strong> <span class="float-end">0000{{ $pesanan->id }}
                                        </span></p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <h6>Billing Info</h6>
                                <address>
                                    {{ Auth::user()->name }}<br>
                                    {{ Auth::user()->email }}<br>
                                </address>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-centered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Foto</th>
                                                <th style="width: 30%" class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($foto as $fotoItem)  
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <img src="{{ Storage::url($fotoItem->foto->fotowatermark) }}"
                                                    alt="contact-img" title="contact-img" class="rounded me-3"
                                                    height="48" />
                                                <p class="m-0 d-inline-block align-middle font-16">
                                                    <a href="ecommerce-product-detail.php"
                                                        class="text-reset font-family-secondary">{{ $fotoItem->foto->event->event }}</a>
                                                    <br>
                                                    <small
                                                        class="me-2"><b>{{ $fotoItem->foto->user->name }}</b></small>
                                                    <small><b>Resolusi :</b> {{ $fotoItem->foto->resolusi }}
                                                    </small>
                                                </p>
                                                </td>
                                                
                                                <td class="text-end">Rp. {{ number_format($fotoItem->foto->harga, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="clearfix pt-5">
                                    <h6 class="text-muted">Notes:</h6>

                                    <small class="text-muted">
                                        All accounts are to be paid within 7 days from receipt of
                                        invoice. To be paid by cheque or credit card or direct payment
                                        online. If account is not paid within 7 days the credits details
                                        supplied as confirmation of work undertaken will be charged the
                                        agreed quoted fee noted above.
                                    </small>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="float-end">
                                    <p><b>Sub-total:</b> <span class="float-end">Rp. {{ number_format($total, 0, ',', '.') }}</span></p>
                                    <p><b>Admin:</b> <span class="float-end">Rp. {{ number_format($adminFee, 0, ',', '.') }}</span></p>
                                    <p><b>Tax (11%):</b> <span class="float-end">Rp. {{ number_format($tax, 0, ',', '.') }}</span></p>
                                    <h3><strong>Rp. {{ number_format($totalPayment, 0, ',', '.') }}</strong></h3>
                                </div>
                                <div class="clearfix"></div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="mt-4 mb-1">
                            <div class="text-end d-print-none">
                                <a href="javascript:window.print()"
                                    class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-printer me-1"></i> Print</a>
                                <button type="button" id="pay-button" class="btn btn-info waves-effect waves-light">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

</div>
@endsection

@push('footer')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        // SnapToken acquired from previous step
        snap.pay('{{ $pesanan->snap_token }}', {
            // Optional
            onSuccess: function(result) {
                window.location.href = '{{ route('user.produk') }}';
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };
</script>
@endpush

