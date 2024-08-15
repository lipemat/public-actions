# Actions Used For Public Repositories

https://docs.github.com/en/actions/using-workflows/avoiding-duplication

> These actions are very specific to [OnPoint Plugin's](https://onpointplugins.com) needs. They are subject to breaking changes without notice and should not be used any type of production environment. I'm not saying the sky may fall if you use them, I'm saying the sky WILL fall if you use them.

Feel free to use the contents of this repo as suggestions for your own actions. In order for our public repos to use them they must be public and GPL compatible.


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
