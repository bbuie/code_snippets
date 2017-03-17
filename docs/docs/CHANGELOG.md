## Buink Change Log

**Step To Create Release**

1. Create a release branch off `develop` (e.g. `release1.1`)
1. Bump the release number in [/README.md](../README.md)
1. Bump the release number in this file and add notes
  - Notes should include a list of all issue numbers and links to those issues
1. Tag the release number (e.g. `git tag v1.1` and `git push origin --tags`)
1. Create pull request into master
1. Create pull request for back into develop
1. Deploy master branch after merge

1.0 release

- Initial commit