# Configure stream wrapper for your filesystems

In order to configure a stream wrapper of your filesystems, you have to install `"twistor/flysystem-stream-wrapper"` with composer.

```bash
composer require twistor/flysystem-stream-wrapper
```

And add it manually in the configuration.

```yaml
oneup_flysystem:
    filesystems:
        my_filesystem:
            adapter: #
            stream_wrapper: myfs
```

This configuration will register a stream wrapper of `my_filesystem` filesystem as a specified protocol `myfs://`.

## Additional stream wrapper configurations

If you want to configure stream wrappers, you can add additional configurations.
The configuration will be passed to 3rd argument of `Twistor\FlysystemStreamWrapper::register($protocol, FilesystemInterface $filesystem, array $configuration)` when registering stream wrapper.

The example below is how to configure same as the default configurations of `"twistor/flysystem-stream-wrapper"`.

```yaml
oneup_flysystem:
    filesystems:
        my_filesystem:
            adapter: #
            stream_wrapper:
                protocol: myfs
                configuration:
                    permissions:
                        dir:
                            private: 0700
                            public: 0755
                        file:
                            private: 0600
                            public: 0644
                    metadata:
                        - timestamp
                        - size
                        - visibility
                    public_mask: 0044
```
