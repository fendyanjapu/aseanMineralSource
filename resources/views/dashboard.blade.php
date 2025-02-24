@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Saldo</h5>
								</div>

								<div class="col-auto">
									<div class="stat text-primary">
										<i class="align-middle" data-feather="dollar-sign"></i>
									</div>
								</div>
							</div>
							<h1 class="mt-1 mb-3">2.382</h1>
							<div class="mb-0">
								<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
								<span class="text-muted">Since last week</span>
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Pemasukan</h5>
								</div>

								<div class="col-auto">
									<div class="stat text-primary">
										<i class="align-middle" data-feather="download"></i>
									</div>
								</div>
							</div>
							<h1 class="mt-1 mb-3">$21.300</h1>
							<div class="mb-0">
								<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
								<span class="text-muted">Since last week</span>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Pengeluaran</h5>
								</div>

								<div class="col-auto">
									<div class="stat text-primary">
										<i class="align-middle" data-feather="external-link"></i>
									</div>
								</div>
							</div>
							<h1 class="mt-1 mb-3">2.382</h1>
							<div class="mb-0">
								<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
								<span class="text-muted">Since last week</span>
							</div>
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection