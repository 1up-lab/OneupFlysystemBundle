# Create a filesystem plugin

The only thing you have to do is to respect the Flysystem plugin API and to add your class as a no-abstract service tagged with "oneup_flysystem.filesystem_plugin"
This implementation add your plugin to all the filesystems.

```
           <services>
               <service id="oneup_flysystem.filesystem_plugin_a" class="Oneup\FlysystemBundle\Tests\FilesystemPlugin\MaximusAwesomeness" abstract="false" public="true">
                   <tag name="oneup_flysystem.filesystem_plugin" />
               </service>
               ...
           </services>
'''