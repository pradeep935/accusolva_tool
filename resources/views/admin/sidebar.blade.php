<?php $access_rights = Session::get("access"); ?>
<div class="sticky">
  <div class="horizontal-main hor-menu clearfix side-header">
    <div class="horizontal-mainwrapper container clearfix">
      <nav class="horizontalMenu clearfix">
        <ul class="horizontalMenu-list">

        @if(in_array(1, $access_rights))
          <li aria-haspopup="true">
            <a class="side-menu__item" href="{{url('/dashboard')}}"><i class="side-menu__icon fe fe-airplay"></i><span class="">Dashboard</span></a>
          </li>
        @endif

        @if(in_array(6, $access_rights))
         <li class="slide">
          <a class="side-menu__item" href="{{url('/projects')}}"><i class='side-menu__icon fas fa-project-diagram' aria-hidden="true"></i><span class="">Projects</span></a>
         </li>
         @endif

        @if(in_array(10, $access_rights))
         <li class="slide">
          <a class="side-menu__item" href="{{url('/users')}}"><i class="side-menu__icon fa fa-user" aria-hidden="true"></i><span class="">Users</span></a>
         </li>
         @endif

        @if(in_array(14, $access_rights))
         <li class="slide">
          <a class="side-menu__item" href="{{url('/clients')}}"><i class="side-menu__icon fa fa-users" aria-hidden="true"></i><span class="">Clients</span></a>
         </li>
         @endif

        @if(in_array(18, $access_rights))
         <li class="slide">
          <a class="side-menu__item" href="{{url('/vendors')}}"><i class="side-menu__icon fa fa-envelope-open" aria-hidden="true"></i><span class="">Vendors</span></a>
         </li>
         @endif

        @if(in_array(19, $access_rights))
         <li class="slide">
          <a class="side-menu__item" href="{{url('/clients/links')}}"><i class="side-menu__icon fa fa-link" aria-hidden="true"></i><span class="">Links</span></a>
         </li>
         @endif

         <?php $setting = DB::table('settings')->where('param', 'show_client_api')->first(); ?>

        @if(in_array(20, $access_rights) && $setting->value == 1 )
         <li class="slide">
          <a class="side-menu__item" href="{{url('/client-api-data')}}"><i class="side-menu__icon fa fa-link" aria-hidden="true"></i><span class="">Client Api Data</span></a>
         </li>
         @endif

        @if(in_array(21, $access_rights))
        <li class="slide">
          <a class="side-menu__item" href="{{url('/access-rights')}}"><i class="side-menu__icon fa fa-link" aria-hidden="true"></i><span class="">Access Rights</span></a>
        </li>
        @endif

         <?php $set = DB::table('settings')->where('param', 'show_setting')->first(); ?>

        @if($set->value == 1 )
          <li class="slide">
            <a class="side-menu__item" href="{{url('/setting')}}"><i class="side-menu__icon fa fa-cog" aria-hidden="true"></i><span class="">Settings</span></a>
          </li>
        @endif

         <li class="slide">
          <a class="side-menu__item" href="{{url('/logout')}}"><i class="side-menu__icon fa fa-link" aria-hidden="true"></i><span class="">Logout</span></a>
         </li>
          </ul>
        </nav>
    </div>
  </div>
</div>
