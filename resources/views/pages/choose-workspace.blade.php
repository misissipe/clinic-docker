<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Choose your workspace | CMIS</title>
  <link rel="shortcut icon" href="{{ asset('images/logo/favicon.ico') }}">
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,600%7CIBM+Plex+Sans:400,500,600,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/choose-workspace.css') }}">
</head>
<body>
  <main class="shell">
    <header>
      <img class="logo" src="{{ asset('images/logo/logo slsu.png') }}" alt="Southern Leyte State University seal">
      <h1>Choose your workspace</h1>
      <p class="subtitle">Select how you want to continue.</p>
    </header>

    @if ($errors->any())
      <div class="error" role="alert">{{ $errors->first() }}</div>
    @endif

    <section class="workspace-grid" aria-label="Available workspaces">
      @foreach ($workspaces as $index => $workspace)
        @php $detail = $workspaceDetails[$workspace['role']]; @endphp
        <article class="workspace-card">
          <div class="icon" aria-hidden="true">{{ $detail['initials'] }}</div>
          <h2>{{ $detail['name'] }}</h2>
          <p class="description">{{ $detail['description'] }}</p>
          <form method="POST" action="{{ route('workspace.select') }}">
            @csrf
            <input type="hidden" name="workspace" value="{{ $index }}">
            <button type="submit">
              Continue as {{ $detail['name'] }}
              <i class="bx bx-right-arrow-alt" aria-hidden="true"></i>
            </button>
          </form>
        </article>
      @endforeach
    </section>

    <footer>
      <div class="identity">
        <div class="avatar">{{ strtoupper(substr(session('firstname', session('name', 'U')), 0, 1)) }}</div>
        <div>
          <p class="signed-in">Signed in as <strong>{{ session('name') }}</strong></p>
          <p class="hint">Choose a workspace to open its dashboard.</p>
        </div>
      </div>
      <a class="sign-out" href="{{ route('workspace.logout') }}"><i class="bx bx-log-out" aria-hidden="true"></i>Sign out</a>
    </footer>
  </main>
</body>
</html>
