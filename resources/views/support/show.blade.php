@extends('app')

@section('content')

<div class="col-md-12">

    <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default">
            <div class="panel-heading">
                Status
            </div>
            <div class="panel-body">
                @if ($ticket->resolved == 'true')
                <h2>Resolved</h2>
                <div class="col-md-6">
                    <p>Result: </p>
                </div>
                <div class="col-md-6">
                    <p>{{$ticket->result}} </p>
                </div>
                @else
                <h2>Open</h2>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Type of issue: </p>
                        </div>
                        <div class="col-md-6">
                            <p>{!! $ticket->type!!} </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Additional details: </p>
                        </div>
                        <div class="col-md-6">
                            <p>{!! $ticket->details !!} </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Associated Transaction:</p>
                        </div>
                        <div class="col-md-6">
                            <p><a href="{{ url('/transactions/'. $ticket->transaction_id) }}">Show Transaction</a></p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    Submitted Evidence
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                    @if (Auth::user()->id == $ticket->complainer_id && $ticket->evidence_added != 'true' )
                    <p>No evidence has been presented by the seller yet.</p>
                    @endif

                    @if (Auth::user()->id == $ticket->complainee_id && $ticket->evidence_added != 'true' )

                    <div class="row">
                        <p>Here you can upload evidence to support your transaction, e.g. postage receipts, pictures of your sale item in working order.</p>
                        <p>You can upload up to 5 evidence images. After submitting the evidence, Randbay will decide on the issue.</p>
                    </div>

                    {!! Form::open(['url' => 'support/evidence/' . $ticket->id, 'id' => 'evidence-form', 'files' => 'true'])!!}

                    <div class="row">
                        <ul class="evidence-list">
                            <li class="evidence-img" style="background-image: url(http://randbay/img/noimage.png);" class="aimg"><span class="label-container">{!! Form::label('evidence-image1', 'ADD') !!}</span><span class="delete-button">DELETE</span>{!! Form::file('evidence-image1') !!}</li>
                            <li class="evidence-img" style="background-image: url(http://randbay/img/noimage.png);" class="aimg"><span class="label-container">{!! Form::label('evidence-image2', 'ADD') !!}</span><span class="delete-button">DELETE</span>{!! Form::file('evidence-image2') !!}</li>
                            <li class="evidence-img" style="background-image: url(http://randbay/img/noimage.png);" class="aimg"><span class="label-container">{!! Form::label('evidence-image3', 'ADD') !!}</span><span class="delete-button">DELETE</span>{!! Form::file('evidence-image3') !!}</li>
                            <li class="evidence-img" style="background-image: url(http://randbay/img/noimage.png);" class="aimg"><span class="label-container">{!! Form::label('evidence-image4', 'ADD') !!}</span><span class="delete-button">DELETE</span>{!! Form::file('evidence-image4') !!}</li>

                        </ul>
                    </div>
                    <button type="button" id="form-submit" class="btn btn-primary form-control" >Submit Evidence</button>
                    {!! Form::close() !!}

                    <div id="message"></div>
                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>


                    <div id="alertModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Please confirm! </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <p>Are you sure you wish to submit these files?</p>
                                            <br>
                                            <p>You will not be able to change the files after submission</p>
                                            <br>
                                        </div>
                                        <div class="row">
                                            <button type="button" id="form-submit-final" class="btn btn-primary form-control" >Yes, I will Submit Evidence</button>
                                        </div>
                                        <div id="spacer"
                                             &nbsp;
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    @else
                        @if (Auth::user()->id == $ticket->complainee_id && $ticket->evidence_added == 'true' )
                        <p>You have submitted the following evidence in response to this ticket.</p>
                        @endif

                        @foreach ($evidence_files as $evidence_file)
                        <div class="row">
                            <div class="col-md-12">
                                <a id="fancy-img" href="{{ url('evidence/' . $ticket->id . '/' . $evidence_file) }}">
                                    {!! Html::image('evidence/' . $ticket->id . '/' . $evidence_file, null, ['id' => 'evidence-img']) !!}
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p style="text-align: center;">{!! $evidence_file !!}</p>
                            </div>
                        </div>
                        <div id="big-spacer">
                            &nbsp;
                        </div>
                        @endforeach

                    @endif

                </div>
            </div>

    </div>

</div>


@stop