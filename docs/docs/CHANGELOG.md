## Buink Change Log

**Current Release**

v1.5.8

**Step To Create Release (release model)**

1. Create a release branch off `develop` (e.g. `release1.0.0`)
1. Bump the release number in [/README.md](../README.md)
1. Bump the release number in this file and add notes
  - Notes should include a list of all issue numbers and links to those issues
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Create pull request into master
1. Create pull request for back into develop
1. Deploy master branch after merge


**Step to release (continuous deployment)**

1. Checkout and update the master branch (e.g 'git checkout master; git pull origin master;)
1. Create a release branch off `master` (e.g. `git checkout -b release1.0.0`)
1. Bump the release number in this file and add notes
  - Notes should include a list of all issue numbers and links to those issues
1. Backup the database to the release branch (if migration is needed)
  - Make sure to test the full build to make sure the new database didn't break the local environment
1. Commit all release changes
1. Merge in the branches to be released and resolve conflicts
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Merge release branch back into master
1. Create pull request into develop
1. Deploy the release branch

**Release History**

#1.0.0

Branch: release1.0.0, Tag: v1.0.0

- [#_issue_number](link_to_pull_request)