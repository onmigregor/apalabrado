<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Buscador de palabras</title>


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
            <div class="content col-6 mx-auto mt-5">
                <form method="post" action="{{ URL::route('buscar-palabra') }}">
                  @csrf
                  <div class="form-group">
                    <input type="text" name="letras" class="form-control" id="letras"placeholder="Introduzca letras"
                    value="{{(isset($data))? $data['letras'] : old('letras') }}">
                    @if($errors->has('letras'))
                        <div class="invalid-feeback">
                          {{$errors->first('letras')}}
                        </div>
                      @endif
                  </div>
                  <div class="form-group">
                    <select name="cantidad" id="cantidad" class="form-control">
                        <option value="">Numero de letras a formar</option>
                        <option value="3"  {{ old("cantidad") == 3 ? "selected" : "" }}>3 palabras</option>
                        <option value="4"  {{ old("cantidad") == 4 ? "selected" : "" }}>4 palabras</option>
                        <option value="5"  {{ old("cantidad") == 5 ? "selected" : "" }}>5 palabras</option>
                        <option value="6"  {{ old("cantidad") == 6 ? "selected" : "" }}>6 palabras</option>
                        <option value="7"  {{ old("cantidad") == 7 ? "selected" : "" }}>7 palabras</option>
                    </select>
                    @if($errors->has('cantidad'))
                        <div class="invalid-feeback">
                          {{$errors->first('cantidad')}}
                        </div>
                      @endif
                  </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form> 

                    @if(isset($response))

                    <div class="col-12 mx-auto mt-4 row">
                        <div class="col-12">
                            <h2 class="text-info">PALABRAS ENCONTRADAS</h2>
                        </div>
                            @foreach($response as $palabra)
                            <div class="col-3">
                                <div class="alert alert-dark" role="alert">
                                    {{$palabra}}
                                </div>
                            </div>
                            @endforeach
                    </div>  
                    @endif
            </div>

            <script type="text/javascript">

                @if (isset($data['cantidad'])) 
                    var can ={{$data['cantidad']}}
                    document.getElementById("cantidad").value = can;
                @endif
            </script>
    </body>
</html>
