# Use the Gitlab adapter

In order to use the Gitlab adapter, you first need to create a Gitlab client service.
This can be done with the following configuration. Read more about instantiating
the Gitlab client at [github.com/RoyVoetman/flysystem-gitlab-storage](https://github.com/RoyVoetman/flysystem-gitlab-storage#usage).

```yml
services:
    acme.gitlab_client:
        class: RoyVoetman\FlysystemGitlab\Client
        arguments:
            - 'project-id'
            - 'branch'
            - 'base-url'
            - 'personal-access-token'
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.gitlab_adapter:
            gitlab:
                client: acme.gitlab_client
                prefix: 'optional/path/prefix'
```

## More to know

* [Create and use your filesystem](filesystem_create.md)
