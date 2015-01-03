<div class="container">
  <div class="row">
    <h2>Welcome <strong><?php echo $user->identity->first_name;?></strong></h2>

    <small>Now you can export your projects,calender,people from here.
    </small>
    <button class="btn btn-large btn-primary pull-right">Export everything</button>
    <hr>

    <div class="col-md-4 col-md-push-4">
      <a href="/basecamp/projects">
        <div class="alert alert-danger">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32">
          <path d="M28 8v-4h-28v22c0 1.105 0.895 2 2 2h27c1.657 0 3-1.343 3-3v-17h-4zM26 26h-24v-20h24v20zM4 10h20v2h-20zM16 14h8v2h-8zM16 18h8v2h-8zM16 22h6v2h-6zM4 14h10v10h-10z" fill="#444444"></path>
          </svg>
          Projects
        </div>
      </a>
      <a href="#" class="btn btn-default btn-lg btn-block">Export</a>
    </div>

    <div class="col-md-4 col-md-pull-4 ">
      <a href="/basecamp/calenders">
        <div class="alert alert-info">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32">
          <path d="M29.334 3h-4.334v-2c0-0.553-0.447-1-1-1s-1 0.447-1 1v2h-6v-2c0-0.553-0.448-1-1-1s-1 0.447-1 1v2h-6v-2c0-0.553-0.448-1-1-1s-1 0.447-1 1v2h-4.333c-1.473 0-2.667 1.193-2.667 2.666v23.667c0 1.473 1.194 2.667 2.667 2.667h26.667c1.473 0 2.666-1.194 2.666-2.667v-23.667c0-1.473-1.193-2.666-2.666-2.666zM30 29.333c0 0.368-0.299 0.667-0.666 0.667h-26.667c-0.368 0-0.667-0.299-0.667-0.667v-23.667c0-0.367 0.299-0.666 0.667-0.666h4.333v2c0 0.553 0.448 1 1 1s1-0.447 1-1v-2h6v2c0 0.553 0.448 1 1 1s1-0.447 1-1v-2h6v2c0 0.553 0.447 1 1 1s1-0.447 1-1v-2h4.334c0.367 0 0.666 0.299 0.666 0.666v23.667zM7 12h4v3h-4zM7 17h4v3h-4zM7 22h4v3h-4zM14 22h4v3h-4zM14 17h4v3h-4zM14 12h4v3h-4zM21 22h4v3h-4zM21 17h4v3h-4zM21 12h4v3h-4z" fill="#444444"></path>
          </svg>
          Calenders
        </div>
      </a>
      <a href="#" class="btn btn-default btn-lg btn-block">Export</a>
    </div>

    <div class="col-md-4">
      <a href="/basecamp/people">
        <div class="alert alert-success"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 36 32">
          <path d="M24 24.082v-1.649c2.203-1.241 4-4.337 4-7.432 0-4.971 0-9-6-9s-6 4.029-6 9c0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h28c0-4.030-5.216-7.364-12-7.918z" fill="#444444"></path>
          <path d="M10.225 24.854c1.728-1.13 3.877-1.989 6.243-2.513-0.47-0.556-0.897-1.176-1.265-1.844-0.95-1.726-1.453-3.627-1.453-5.497 0-2.689 0-5.228 0.956-7.305 0.928-2.016 2.598-3.265 4.976-3.734-0.529-2.39-1.936-3.961-5.682-3.961-6 0-6 4.029-6 9 0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h8.719c0.454-0.403 0.956-0.787 1.506-1.146z" fill="#444444"></path>
          </svg>
          People
        </div>
      </a>
      <a href="#" class="btn btn-default btn-lg btn-block">Export</a>
    </div>

  </div>
</div>
