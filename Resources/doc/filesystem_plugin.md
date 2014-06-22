# Create a filesystem plugin

The only thing you have to do is to respect the Flysystem plugin API and to add your class as a no-abstract service tagged with "oneup_flysystem.filesystem_plugin.__your_fs_name__"
You can use the wildcard "__all__" instead of a filesystem name : it will add your plugin to all the filesystems.


XML Example to add to the Ressources/config/services.xml (by default) of the bundle where you want to develop your plugin:
```
           <services>
               <service id="oneup_flysystem.filesystem_plugin_a" class="MyName\Bundle\MyAwesomePlugin" abstract="false" public="true">
                   <tag name="oneup_flysystem.filesystem_plugin.__all__" />
               </service>
               ...
           </services>
'''
In this case, your "MyName\Bundle\MyAwesomePlugin" will be added to all the filesystems.

A second example : add your plugin to specifics filesystems:
```
           <services>
               <service id="oneup_flysystem.filesystem_plugin_a" class="MyName\Bundle\MyAwesomePlugin" abstract="false" public="true">
                   <tag name="oneup_flysystem.filesystem_plugin.mylocal1" />
                   <tag name="oneup_flysystem.filesystem_plugin.myftp1" />
               </service>
               ...
           </services>
'''
In this case, your "MyName\Bundle\MyAwesomePlugin" will be added to your filesystems mylocal1 and myftp1.

After you can call your plugin like this:
'''
$fs = $filesystemMap->get("fs_name");
echo $fs->getDown();
