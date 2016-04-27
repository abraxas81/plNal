<div class="form-group">
    <label class="col-lg-5 control-label" for="dozvole">Dozvole</label>
    <div class="col-lg-7">
        <select id="dozvole" name="dozvole[]" class="form-control input-sm" multiple style="width: 100%">
            @foreach($dozvole as $dozvola)
                <option value="{{$dozvola->id}}">{{$dozvola->name}}</option>
            @endforeach
        </select>
    </div>
</div>

@section('js')
<script>$('#dozvole').select2({"language":"hr"});</script>
@parent
@endsection



