<div id="PostavkeOperatera" class="modal fade" role="dialog" data-modal-index="1">
    <div class="modal-dialog">
        <form id="operateri" class="form-horizontal main operateri" action="{{url('operateri/operateri/'.Auth::user()->id)}}" method="POST">
            <input id="postMethod" type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Postavke operatera</h4>
                </div>
                <div class="modal-body">
                    @include('datatables.admin.operateri.form')
                </div>
                <div class="modal-footer">
                    <button id="spremi" type="submit" class="btn btn-primary btn-sm">{{isset($gumbSpremiTxt)?$gumbSpremiTxt:'Spremi'}}</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{isset($gumbZatvoriTxt)?$gumbZatvoriTxt:'Zatvori'}}</button>
                </div>
            </div>
        </form>
    </div>
</div>