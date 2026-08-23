# repo-health-score

GitHub Action that generates an SVG badge with the repository [community health score](https://docs.github.com/en/communities/setting-up-your-project-for-healthy-contributions/about-community-profiles-for-public-repositories).

## Usage

Add this workflow to your repository:

```yaml
name: Generate Badge
on:
  schedule:
    - cron: "0 2 * * *"
  workflow_dispatch:
permissions:
  contents: write
jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: Generate repo health score badge
        uses: ale94lko/repo-health-score@main
        with:
          token: ${{ secrets.GITHUB_TOKEN }}
```

The badge is published to the `output` branch as `badge.svg`.

## Embed the badge

```markdown
![Health Score](https://raw.githubusercontent.com/OWNER/REPO/output/badge.svg)
```

## Local run

```bash
composer install
REPOSITORY=owner/repo GITHUB_TOKEN=ghp_xxx php index.php
```

The SVG is written to `dist/badge.svg`.
