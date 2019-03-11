<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jacob
 * Date: 3/8/19
 * Time: 4:30 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="bg-dark dk">

    <div class="container">
        <div class=" wrapper">

            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <strong><i class="fa fa-info"></i> HOW TO ENCRYPT</strong>
                        </div>
                        <div class="panel-body">
                            @foreach ($how_tos as $hows)
                                <strong class="text-warning"><i class="fa fa-info-circle"></i> {{ $hows->title }}</strong>
                                <p class="text-light">{{ $hows->content }}</p>
                                <p style="font-size:9px;">Updated: {{ $hows->TIMESTAMP}}</p>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-body">
                            @foreach ($snippets as $snips)
                            <strong class="text-warning"><i class="fa fa-info-circle"></i> {{ $snips->title }}</strong>
                            <p class="text-light">{{ $snips->content }}</p>
                            <p style="font-size:9px;">Updated: {{ $snips->TIMESTAMP}}</p>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>