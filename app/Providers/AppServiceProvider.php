<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use App\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
     
      
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
          // $user=User::find(\Auth::user()->id);
           $event->menu->add(
              [
                'text' => 'Home',
                'url'  => 'home',
                'icon' => 'fas fa-fw fa-home',
            ],
            ['header' => 'account_settings'],
            [
                'text' => 'Profile',
                'url'  => route('user.data',\Auth::user()),
                'icon' => 'fas fa-user fa-lg mr-1 my-2',
              
            ],
            [
                'text' => 'change password',
                'url'  => route('profile.change.form'),
                'icon' => 'fas fa-fw fa-lock my-2',
                
            ],
            );
            if(\Auth::check()){
              if(\Auth::user()->role == 0)
              {
                
                $event->menu->add('Admin');
                $event->menu->add(
                  [
                    'text' => 'Add User',
                    'icon'=>'fas fa-fw fa-user-plus my-2',
                    'url' => route('user.create'),
                    //'icon_color' => 'orange',
                  ],
                  
                  [
                    'text' => 'System Rates',
                    'icon'=>'fas fa-fw fa-star',
                    'url'  => route('system.rates'),
                  ],
                  
                  [
                    'text' => 'Users',
                    'icon'    => 'fas fa-fw fa-users my-2',
                    'submenu' => 
                    [
                      [
                        
                          'text' => 'Admins',
                          'icon' => 'fas fa-fw fa-user-circle',
                          'url'  => route('users',0),
                      ],
                      [
                        'text' => 'Employees',
                        'icon'=>'fas fa-fw fa-user-circle',
                        'url'  => route('users',1),
                      ],
                      [
                        'text' => 'Customers',
                        'icon'=>'fas fa-fw fa-user-circle',
                        'url'  => route('users',2),
                      ],
                    ]
                  ],
                  [
                    'text'    => 'Complains',
                    'icon'=>'fas fa-fw fa-th my-2',
                    'submenu' => 
                    [
                      [
                        'text' => 'Unsigned',
                        'icon'=>'fas fa-fw fa-exclamation',
                        //fa-times
                       'url'     => route('complain.all',0),
                      ],
                      [
                        'text' => 'Signed',
                        'icon' => 'fas fa-fw fa-check',
                        'url'  => route('complain.all',1),
                      ],
                      [
                        'text' => 'history',
                        'icon'=>'fas fa-fw fa-history',
                        'url'  => route('complain.all',2),
                      ],
                    ]
                  ],  
                  

                  

              );

              }
              else if(\Auth::user()->role == 1)
              {
                $event->menu->add('Employee');
                $event->menu->add(
                  [
                    'text'    => 'Complains',
                    'icon'    =>'fas fa-fw fa-th',
                    'url'     => route('complain.all',1),
                  ],
                );
              }
            
            else 
            {
             $event->menu->add('customer');
             $event->menu->add(
              [
                'text' => 'Create Complian',  
                'url' => route('complain.create'),
                'icon'=>'fas fa-fw fa-plus',
                //'icon_color' => 'orange',
              ],
              
              [
                'text' => 'Complains History',
                'url' => route('complain.all',2),
                'icon'=>'fas fa-fw fa-history ',
                //'icon_color' => 'orange',
              ],
              
            );
            if(\Auth::user()->rate->ActiveReplies)
           {
             $event->menu->add(                 
               [
                 'text' => 'Complains active Replies ',
                 'url' => route('complain.replies',1),
                 'icon'=>'far fa-comment-alt mr-1',
                 'icon_color' => 'orange',
                 'label'       => \Auth::user()->rate->ActiveReplies,
                 'label_color' => 'success',
               ],
             );
           }$event->menu->add(
           
          
           [
            'text' => 'Complains Replies',
             'url' => route('complain.replies',0),
            'icon'=>'far fa-comment-alt mr-1',
            //'icon_color' => 'orange',
          ],);

              }
            }
          });
    }
}
