<div class="col-md-2">
    
    @if(Auth::user()->hasRole('Todo'))
    <?php 
    $laravelAdminMenus->menus = $laravelAdminMenus->menus
    ?>
    @else
    <?php 
    unset($laravelAdminMenus->menus[2]); 
    unset($laravelAdminMenus->menus[3]); 
    ?>
    @endif

    @foreach($laravelAdminMenus->menus as $section)        
        @if($section->items)       
            <div class="card border-light">
                <div class="card-header">
                   <b>{{ $section->section }}</b>
                </div>

                <div class="card-body ">
                    <ul class="nav flex-column" role="tablist">
                        @foreach($section->items as $menu)
                            <li class="nav-item" role="presentation">
                                <a class="nav-item" href="{{ url($menu->url) }}">
                                    
                                    {{ $menu->title }}

                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <br/>
        
        
        
        @endif
    @endforeach
</div>
