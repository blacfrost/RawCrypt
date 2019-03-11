<div class="bg-dark dk">

    <div class="container">
        <div class=" wrapper">

            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <strong><i class="fa fa-lock"></i> ENCRYPTION FORM</strong>
                        </div>
                        <form id="encrypt_form">
                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="passkey">Passkey:</label>
                                    <input type="text" name="pk" class="form-control" id="pk" placeholder="Enter your secret passkey here">
                                </div>

                                <div class="form-group">
                                    <label for="content">Content:</label>
                                    <textarea class="form-control" name="content" id="content" rows="25" placeholder="Paste data to encrypt here."></textarea>
                                </div>

                            </div>
                            <div class="panel-footer">
                                <div id="error" class="text-danger" hide>ERROR: Incomplete Data. Please Resubmit. </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> ENCRYPT YOUR DATA</button>
                            </div>
                        </form>
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel" id="output_panel">
                        <div class="panel-heading">
                            <strong><i class="fa fa-lock"></i> ENCRYPTED DATA OUTPUT</strong>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="unique_url">Your Unique URL <br><span class="text-warning">(Copy or Write Down)</span></label>
                                <input type="text" readonly class="form-control" id="unique_url" placeholder="Unique URL">
                            </div>
                            <textarea id="encrypted_output" disabled class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

</div>


    <script>

        $(document).ready(function() {
            $("#error").hide();
            //$("#output_panel").hide();
        });

        // this is the id of the form
        $("#encrypt_form").submit(function(e) {

            //var itemID = $(this).attr('#ItemNumber');
            var form = $(this);
            //var url = form.attr('action');
            var url = "{{ route('encrypt.it') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements. May be a problem upon decrypt
                success: function(data){
                    //console.log(JSON.parse(data));

                    if(data.includes("ERROR")){
                        $("#error").show();
                        alert('Missing critical data. Please resubmit.');
                    } else {
                        var arr = JSON.parse(data);
                        //console.log(arr);
                        //$("#encrypted_output").text(arr[0]);
                        //$("#unique_url").text('http://rawcrypt.com/public/decrypt/' + arr[1]);

                        $('textarea[id=encrypted_output]').val(arr[0]);
                        $('input[id=unique_url]').val('http://rawcrypt.com/public/decrypt/' + arr[1]);
                        $("#output_panel").show();
                    }

                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });


    </script>






