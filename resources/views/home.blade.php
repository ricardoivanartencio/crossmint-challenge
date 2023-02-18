<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
    
    <script src="{{ mix('js/app.js') }}"></script>

    <title>Crossmint Challenge</title>
</head>
<body>
    <div id="overlay">
        <div id="loader"></div>
    </div>

    <main>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <h3>Crossmint Challenge</h3>
        </nav>

        <div class="alert-messages">
          @if (session('message'))
            @if (session('message')['type'] === 'success')
            <div class="alert alert-success {{ session('message')['dismissible'] ? 'alert-dismissible' : '' }}">
                {{ session()->get('message')['text'] }}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                </svg>
                @if (session('message')['dismissible'])
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  @endif
            </div>
            @elseif (session('message')['type'] === 'error')
                <div class="alert alert-error {{ session('message')['dismissible'] ? 'alert-dismissible' : '' }}">
                    {{ session()->get('message')['text'] }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                      <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                    </svg>
                    @if (session('message')['dismissible'])
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endif
                </div>
            @endif
          @endif
            
        </div>
        

        <div class="row justify-content-center">
          <div class="col-sm-12 d-flex justify-content-center">
            <h1 class="title">Ricardo Ivan Artencio</h1>
          </div>
        </div>
        
        <div class="container text-center">
          <div class="row justify-content-md-center">

            @foreach ($exercises as $exe)
              <div class="col-md-3 col-sm-6">
                <div class="card">
                  <img src="{{ asset('storage/images/'.$exe["image"].'.PNG') }}" alt="Crossmint 1st Challenge Complete">
                  
                  <div class="card-body">
                    <p class="card-text">{{$exe["text"]}}</p>

                    <div class="d-flex justify-content-center">
                      <div class="btn">
                        
                        <form action="/{{$exe["name"]}}" method="POST">
                          @csrf
                          <input type="hidden" value="{{$exe["name"]}}" name="id">

                          <input type="submit" class="btn btn-outline-info" onclick="showOverlay()" value="{{$exe["action"]}}">
                        </form>

                      </div>  
                    </div>

                  </div>

                </div>
              </div>
            @endforeach

          </div>
        </div>

    </main>
</body>

<script>
  function showOverlay() {
        document.getElementById('overlay').style.display = 'flex';
    }
    
    function hideOverlay() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

</html>