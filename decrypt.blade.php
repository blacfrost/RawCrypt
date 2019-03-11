
<div class="bg-dark dk">

    <div class="container">
        <div class=" wrapper">

            <div class="row">
                <div class="col-sm-12 col-lg-8">


                        <div class="panel">
                            <div class="panel-heading">
                                <strong><i class="fa fa-lock"></i> DECRYPT YOUR DATA</strong>
                            </div>
                            <div class="panel-body">
                                <form id="decrypt_form">
                                    <div class="form-group">
                                        <label for="passkey"><strong>PASSKEY:</strong></label>
                                        <input type="text" name="pk" class="form-control" id="pk" autocomplete="off" placeholder="Enter your secret passkey to decrypt your data">
                                    </div>
                                    <input type="hidden" value="{{ $url }}" name="data_url">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> PROCESS DECRYPTION</button>
                                </form>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="content"><strong><i class="fa fa-unlock"></i> DECRYPTED DATA OUTPUT:</strong></label>
                                    <textarea class="form-control" name="decrypted" id="decrypted" rows="25"></textarea>
                                    <div id="ts"></div>
                                </div>
                            </div>

                    </div>

                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="panel">
                        <div class="panel-body">
                            <strong><i class="fa fa-info"></i> SITE ENCRYPTION DETAILS</strong>
                            <hr>
                            @foreach ($site_contents as $con)
                            <strong class="text-warning"><i class="fa fa-lock"></i> {{ $con->title }}</strong>
                            <p class="text-light">{{ $con->content }}</p>
                            <p style="font-size:9px;">Updated: {{ $con->TIMESTAMP}}</p>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <strong><i class="fa fa-money"></i> DONATIONS</strong>
                        </div>
                        <div class="panel-footer" style="padding:5px;">
                            <p>If you like RawCrypt.com and want to help out on future development features, donations are always welcome.</p>
                            <span style="font-size:10px;">
                            <p class="text-warning"><Strong>BTC:</Strong> 36L7UhGYtP4N1me1dC2NwGTBvCZ1S3zfKh</p>
                            <p class="text-warning"><Strong>ETH:</Strong> 0x2B921Af89CBc5896e950AcD744345919efbCb72e</p>
                            <p>-Thank you!</p>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>


    <script>

        $(document).ready(function() {
            $("#error").hide();
        });

        // this is the id of the form
        $("#decrypt_form").submit(function(e) {

            var form = $(this);
            var url = "{{ route('decrypt.it') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements. May be a problem upon decrypt
                success: function(data){
                    console.log(data);
                    var arr = JSON.parse(data);
                    if(data.includes("ERROR")){
                        $('textarea[id=decrypted]').val(arr[0]);
                        $('#ts').html('<b>Created:</b> ' + arr[1]);
                    } else {
                        $('textarea[id=decrypted]').val(arr[0]);
                        $('#ts').html('<b>Encrypted Date:</b> ' + arr[1]);
                    }

                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });


    </script>






