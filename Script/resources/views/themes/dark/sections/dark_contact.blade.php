@if(isset($dark_contact))
    <section class="contact-section">
        <div class="container">
            <div class="text-center mb-50">
                <h2>{{ @$dark_contact['single']['title'] }}</h2>
                <p class="mt-10 mb-0">{{ @$dark_contact['single']['sub_title'] }}</p>
            </div>
            <div class="contact-area mb-50">
                <div class="contact-item-list">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="item">
                                <div class="icon-area">
                                    <i class="fa-light fa-phone"></i>
                                </div>
                                <div class="content-area">
                                    <h6 class="mb-0">@lang('Phone:')</h6>
                                    <p class="mb-0">{{ @$dark_contact['single']['phone'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="item">
                                <div class="icon-area">
                                    <i class="fa-light fa-envelope"></i>
                                </div>
                                <div class="content-area">
                                    <h6 class="mb-0">@lang('Email:')</h6>
                                    <p class="mb-0">{{ @$dark_contact['single']['email'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="item">
                                <div class="icon-area">
                                    <i class="fa-light fa-location-dot"></i>
                                </div>
                                <div class="content-area">
                                    <h6 class="mb-0">@lang('Address:')</h6>
                                    <p class="mb-0">{{ @$dark_contact['single']['location'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 g-xxl-5 align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="contact-message-area">
                        <div class="contact-header">
                            <h3 class="section-title">{{ @$dark_contact['single']['form_title'] }}</h3>
                            <p>{{ @$dark_contact['single']['form_sub_title'] }}</p>
                        </div>
                        <form action="{{route('contact.send')}}" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="email" class="form-control" placeholder="E-mail Address" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <input type="text" class="form-control" placeholder="Your Subject" name="subject" value="{{ old('subject') }}">
                                    @error('subject')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb  -3 col-12">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                              placeholder="Your Massage" name="message">{{ old('message') }}</textarea>
                                    @error('message')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="btn-area">
                                <button type="submit" class="cmn-btn"><span>{{ @$dark_contact['single']['button'] }}</span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="left-side">
                        <div class="img-box">
                            <img src="{{ getFile($dark_contact['single']['media']->image->driver, $dark_contact['single']['media']->image->path) }}" alt="@lang('Contact Image')">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endif

