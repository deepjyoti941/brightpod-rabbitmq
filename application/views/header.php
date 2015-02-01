<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>Basecamp Exporter</title>
  <meta name="description" content="">

  <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/toastr.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/main.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/lib/wysiwyg/css/bootstrap3-wysiwyg5.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/lib/toastr/toastr.css')?>" rel="stylesheet">

  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

</head>

<body>
  <div class="navbar navbar-inverse" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Brightpod Projects</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li <?php if ( '/'.$this->uri->uri_string() == '/mailQueue'): ?> class="active"<?php endif; ?>><a href="/mailQueue">Mail Queue</a></li>
          <li <?php if ( '/'.$this->uri->uri_string() == '/notes'): ?> class="active"<?php endif; ?>><a href="/notes">Notes</a></li>
          <li <?php if ( '/'.$this->uri->uri_string() == '/'): ?> class="active"<?php endif; ?>><a href="/">Basecamp exporter</a></li>
          <li <?php if ( '/'.$this->uri->uri_string() == '/timer'): ?> class="active"<?php endif; ?>><a href="/timer">Timer</a></li>
          <li class="loader" style="color:#ffffff; opacity: 0.6; display: none"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></li>
        </ul>
      </div>
    </div>
  </div>
