{{--Footer Section Start --}}
<footer class="main-panel card border footer-bg p-4" id="footer">
    <div class="container-fluid container-fluid-90">
        <div class="row">
            <div class="col-6 col-sm-3 mt-4">
                <h2 class="font-weight-700">{{ __('Hosting') }}</h2>
                <div class="row">
                    <div class="col p-0">
                        <ul class="mt-1">
                            @if (isset($footer_first))
                                @foreach ($footer_first as $ff)
                                <li class="pt-3 text-16">
                                    <a href="{{ url($ff->url) }}">{{ $ff->name }}</a>
                                </li>

                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-3 mt-4">
                <h2 class="font-weight-700">{{ __('Company') }}</h2>
                <div class="row">
                    <div class="col p-0">
                        <ul class="mt-1">
                            @if (isset($footer_second))
                                @foreach ($footer_second as $fs)
                                <li class="pt-3 text-16">
                                    <a href="{{ url($fs->url) }}">{{ $fs->name }}</a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-3 mt-4">
                 @if (!top_destinations()->isEmpty())
                    <h2 class="font-weight-700">{{ __('Top Destination') }}</h2>
                    <div class="row">
                        <div class="col p-0">
                            <ul class="mt-1">
                                    @foreach (top_destinations() as $pc)
                                        <li class="pt-3 text-16">
                                            <a href="{{ url('search?location=' .  $pc->name . '&checkin=' . date('d-m-Y') . '&checkout=' . date('d-m-Y') . '&guest=1">') }}">{{ $pc->name }}</a>
                                        </li>
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>


            <div class="col-6 col-sm-3 mt-5">
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a href="{{ url('/') }}">{!! getLogo('img-130x32') !!}</a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="social mt-4">
                        <ul class="list-inline text-center">
                            @if (isset($join_us))
                                @for ($i=0; $i<count($join_us); $i++)
                                    @if ($join_us[$i]->value <> '#')
                                        <li class="list-inline-item">
                                            <a class="social-icon  text-color text-18" target="_blank" href="{{ $join_us[$i]->value }}" aria-label="{{ $join_us[$i]->name }}"><i class="fab fa-{{ str_replace('_','-',$join_us[$i]->name) }}"></i></a>
                                        </li>
                                    @endif
                                @endfor
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <p class="text-center text-underline">
                            <a href="#" aria-label="modalLanguge" data-toggle="modal" data-target="#languageModalCenter"> <i class="fa fa-globe"></i> {{ Session::get('language_name')  ?? $default_language->name }} </a>
                            <a href="#" aria-label="modalCurrency" data-toggle="modal" data-target="#currencyModalCenter"> <span class="ml-4">{!! Session::get('symbol')  !!} - <u>{{ Session::get('currency')  }}</u> </span></a>
                        </div>
                    </div>
                </div>
        </div>
    </div>

	<div class="border-top p-0 mt-4">
		<div class="row  justify-content-between p-2">
			<p class="col-lg-12 col-sm-12 mb-0 mt-4 text-14 text-center">
			© 2017-{{ date('Y') }} {{ siteName() }}. {{ __('All Rights Reserved') }}</p>
		</div>
	</div>
</footer>

<div class="row">
    {{--Language Modal --}}
    <div class="modal fade mt-5 z-index-high" id="languageModalCenter" tabindex="-1" role="dialog" aria-labelledby="languageModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                        <h5 class="modal-title text-20 text-center font-weight-700" id="languageModalLongTitle">{{ __('Choose Your Language') }}</h5>
                    </div>

                    <div>
                        <button type="button" class="close text-28 mr-2 filter-cancel" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body pb-5">
                    <div class="row">
                        @foreach ($language as $key => $value)
							<div class="col-md-6 mt-4">
								<a href="javascript:void(0)" class="language_footer {{ (Session::get('language') == $key) ? 'text-success' : '' }}" data-lang="{{ $key }}">{{ $value }}</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

    {{--Currency Modal --}}
    <div class="modal fade mt-5 z-index-high" id="currencyModalCenter" tabindex="-1" role="dialog" aria-labelledby="languageModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="w-100 pt-3">
						<h5 class="modal-title text-20 text-center font-weight-700" id="languageModalLongTitle">{{ __('Choose a Currency') }}</h5>
					</div>

					<div>
						<button type="button" class="close text-28 mr-2 filter-cancel font-weight-500" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>

				<div class="modal-body pb-5">
					<div class="row">
						@foreach ($currencies as $key => $value)
						<div class="col-6 col-sm-3 p-3">
							<div class="currency pl-3 pr-3 text-16 {{ (Session::get('currency') == $value->code) ? 'border border-success rounded-5 currency-active' : '' }}">
								<a href="javascript:void(0)" class="currency_footer " data-curr="{{ $value->code }}">
									<p class="m-0 mt-2  text-16">{{ $value->name }}</p>
									<p class="m-0 text-muted text-16">{{ $value->code }} - {!! $value->org_symbol !!} </p>
								</a>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
        </div>
    </div>
</div>
