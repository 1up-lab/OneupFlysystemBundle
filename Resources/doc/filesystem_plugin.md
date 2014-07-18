# Create a filesystem plugin

The only thing you have to do is to respect the Flysystem plugin API and to add your class as a non-abstract service tagged with "oneup_flysystem.filesystem_plugin"
You can provide the filesystem property to attach the plugin to a specific plugin. If you leave it empty, it will be attached to all filesystems defined within the configuration of this bundle.

```xml
<services>
    <!-- A global plugin -->
    <service id="myname_bundle.first_plugin" class="MyName\Bundle\MyAwesomePlugin">
       <tag name="oneup_flysystem.filesystem_plugin" />
    </service>

    <!-- A local plugin -->
    <service id="myname_bundle.second_plugin" class="MyName\Bundle\MyAwesomePlugin">
       <tag name="oneup_flysystem.filesystem_plugin" filesystem="foobar" />
    </service>
   ...
</services>
```

While `first_plugin` is availabe in all the filesystems, the plugin `second_plugin` will only be attached to the filesystem with the name `foobar`.