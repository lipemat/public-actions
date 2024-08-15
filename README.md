# Actions Used For Public Repositories

https://docs.github.com/en/actions/using-workflows/avoiding-duplication

> These actions are very specific to [OnPoint Plugin's](https://onpointplugins.com) needs. They are subject to breaking changes without notice and should not be used any type of production environment. I'm not saying the sky may fall if you use them, I'm saying the sky WILL fall if you use them.

Feel free to use the contents of this repo as suggestions for your own actions. In order for our public repos to use them they must be public and GPL compatible.

## Versioning

GitHub Actions do not support getting minor or patch versions of an action without changing the workflow. For example, if you point to `@v1` you will not get `@v1.1` without changing the workflow. Typically, this is handled changing the ref that the `@v1` tag points to through either a special GitHub Action or manually tagging with `-f`. 

Instead of using traditional tags for action version we use branches to allow for quickly deploying updates while still handling breaking changes with major version updates.

Examples:
- `@version/1` will always get the latest of major version 1. Think of it like `@v1.*.*` or in semver `^1.0.0`
- `@version/2` will always get the latest of major version 2. Think of it like `@v2.*.*` or in semver `^2.0.0`
- Pointing to a particular ref or commit is also supported.


## Composite Actions

Composite actions must be stored in a directory with an action.yml file.

https://docs.github.com/en/actions/creating-actions/creating-a-composite-action

## Reusable Workflows

Reusable workflows may be any valid yml file stored in .github/workflows in the repository.
We Keep them in the root for easy access.

https://docs.github.com/en/actions/using-workflows/reusing-workflows

## Examples

### Composite Action

```yaml
jobs:
  populate:
    name: Populate all caches
    runs-on: ubuntu-latest
    steps:
      - name: Setup Node and PHP
        uses: lipemat/public-actions/setup-dependencies@v1
```

### Reusable Workflow

```yaml
name: Deploy Production

on:
  push:
    branches:
      - server/production

jobs:
  deploy:
    name: Deploy to production
    uses: lipemat/actions/.github/workflows/deploy-cpanel.yml@v1
    with:
      remote: 'ssh://some-ssh-git-repo.com/home/startingpoint/public_html'
      server: 'production'
      url: 'https://site-url.example.com'
    secrets: inherit
```
