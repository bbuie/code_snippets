### Setup Your Local Development Enviornment

1. Use our [Docker Setup Steps](../docker/README.md) to run this repository locally

### Developer user

You can use the following credentials to login to the site locally:

Username: wpadmin
Password: wpadmin

### Branching model (release model)

1. We use the branching model found here: http://nvie.com/posts/a-successful-git-branching-model/
1. Always branch new features off the `develop` branch (`git checkout -b feature_branch_name`)
    - feature_branch_name should start with the issue number and be as short as possible (e.g. 999-example-name)
    - Important: each ticket number should only have one branch and all related changes should be kept on it
    - Important: it is helpful to make a note of the branch name on the issue/card/ticket
1. Commit your changes to the feature branch using the ticket number (e.g. `#999 - added some stuff for new feature`)
    - Always include the issue number at the beginning of the commit message (`git commit -m '#999 - added some stuff for new feature'`)
    - Before you commit your changes, please run a `git diff` to make sure that the changes you're comitting are in fact the changes you want to commit.
1. Ensure that your branch has no linting errors
1. Push your changes to this repo
    - IMPORTANT: make sure your branch is up-to-date with it's parent branch (in this case `develop`) by updating the parent and merging it in often
1. Create a **pull request** from your feature branch to the `develop` branch
    - The title of the pull request is important
        - The title of your pull request should include the issue number and the branch you're merging into (e.g. "999 to develop")
        - You may also want to include a short description of the issue (e.g. "999 to develop | insert_short_description_of_999")
    - Include a link to the original card/ticket/issue
    - Include a GIF of your changes if they affect what a users sees in a browser
        - Try to capture the user story of the issue in the GIF
        - If the user story is difficult to capture in just one GIF, then make two
        - Use [licecap](http://www.cockos.com/licecap/) if you need a good GIF software.
    - Provide a summary of the work you completed in the description of the pull request
1. If there are merge conflicts fix them
    - IMPORTANT: Merge conflicts must result in a conversation with the developer who wrote the conflicting code
    - IMPORTANT: Merge conflicts present the hazard of loosing code or introducing bugs. There is also the hazard of leaving code in the codebase that is no longer in use. Please take extra care to avoid these hazards.
1. Review the "diff" of your code
    - Both popular repository websites (Github & Bitbucket) provide the ability to review and comment on your code changes
    - Make sure all changes are needed and wanted
    - Comment to explain any unusual code
        - Particularly code that has been removed
    - Clean up code
1. Add "Steps to QA" to the original issue/card/ticket so the reviewer can quickly know what changed and why
    - Some issues already have these
    - These are only required if the changes are difficult or counterintuitive to test
1. Add "Steps to go live" to the original issue/card/ticket if going live requires running a migration or other steps not easily apparent
1. Request a review from the developer lead

### Step To Create Release (release model)

1. Create a release branch off `develop` (e.g. `release1.0.0`)
1. Bump the release number in [/README.md](../README.md)
1. Bump the release number in this file and add notes
    - Notes should include a list of all issue numbers and links to those issues
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Create pull request into master
1. Create pull request for back into develop
1. Deploy master branch after merge

### Branching model (continuous deployment)

1. Always branch new features off the `master` branch (`git checkout -b feature_branch_name`)
    - feature_branch_name should start with the issue/ticket/card number and be as short as possible (e.g. 999-example-name)
    - IMPORTANT: each issue/ticket/card should only have one branch and all related changes should be kept on it
    - IMPORTANT: it is helpful to make a note of the branch name on the issue/ticket/card
1. Commit your changes to the feature branch using the issue/ticket/card number (e.g. `#999 - added some stuff for new feature`)
    - Always include the issue number at the beginning of the commit message (`git commit -m '#999 - added some stuff for new feature'`)
    - Before you commit your changes, please run a `git diff` to make sure that the changes you're comitting are in fact the changes you want to commit.
1. Ensure that your branch has no linting errors
1. Push your changes to this repo
    - IMPORTANT: make sure your branch is up-to-date with it's parent branch (in this case `master`) by updating the parent and merging it in often
1. Create a **pull request** from your feature branch to the `develop` branch
    - The title of the pull request is important
        - The title of your pull request should include the issue number and the branch you're merging into (e.g. "999 to develop")
        - You may also want to include a short description of the issue (e.g. "999 to develop | insert_short_description_of_999")
    - Include a link to the original issue/ticket/card
    - Include a GIF of your changes if they affect what a users sees in a browser
        - Try to capture the user story of the issue in the GIF
        - If the user story is difficult to capture in just one GIF, then make two
        - Use [licecap](http://www.cockos.com/licecap/) if you need a good GIF software.
    - Provide a summary of the work you completed in the description of the pull request
1. If there are merge conflicts...
    1. Check that your branch is up to date with master
        - Most of the time, conflicts can be fixed by merging in master and resolving conflicts there.
    1. Make your code dependent on the third party branch that is conflicting
        - Find the lines of code that are conflicting
            - The easiest way to do this is to TEMPORARILY merge the develop branch, check for conflicting lines, and then ABORT the merge (e.g. `git checkout develop; git pull origin develop; git checkout 999-example-name; git merge develop; git diff --check; git merge --abort`)
            - IMPORTANT: you should make sure you abort the merge otherwise merging the develop branch will cause big issues in the future
        - Use the blame feature of GIT to find both who's code yours is conflicting with and which branch it is related to
        - Then, you need to merge that branch into your branch and resolve the conflict
        - IMPORTANT: make sure to note on the issue/ticket/card that a conflict was resolved and that your branch is now dependent on another branch
        - IMPORTANT: it is very easy to make mistakes when resolving conflicts. Common mistakes include code being accidentally removed that was important or code that should have been removed being added back. For this reason, you should always talk to the developer who wrote the conflicting code.
    1. In rare cases where it is not possible to determine who's branch caused the conflict
        - contact the team's developer lead
    1. In all cases, merge conflicts must result in a conversation with the developer who wrote the conflicting code
1. Review the "diff" of your code
    - Both popular repository websites (Github & Bitbucket) provide the ability to review and comment on your code changes
    - Make sure all changes are needed and wanted
    - Comment to explain any unusual code
        - Particularly code that has been removed
    - Clean up code
1. If you haven't already, make sure there is an open pull request for this branch into develop
    - NOTE: each issue/ticket/card should usually have only one merge into master
1. Add "Steps to QA" to the original issue/ticket/card so the reviewer can quickly know what changed and why
    - Some issues already have these
    - These are only required if the changes are difficult or counterintuitive to test
1. Add "Steps to go live" to the original issue/ticket/card if going live requires running a migration or other steps not easily apparent
1. Request a review from the developer lead

### Steps to Create Release (continuous deployment)

1. Review all "Going live" steps for issues eligible in the release
1. Backup the database to the release branch (if migration is needed)
    - Make sure to test the full build to make sure the new database didn't break the local environment
1. Merge all feature branches into master
1. Create a release here: [Releases](./CHANGELOG.md)
    1. Determine the new release number; e.g. `v1.0.0`
    1. Target the master branch
    1. Put links to issue numbers in the release notes
1. Deploy changes to production:
    1. [These steps will vary]
1. Merge master back into develop
1. Alter the involved parties of the release on the issue
1. Move/label the issue appropriately

###Code style guide

It is important that you write your code in a cost effective way that makes it easy to understand, update, and maintain. The following are some principles you should keep in mind:

- Here are [general code requirements](https://github.com/bbuie/code_snipits/wiki/Common-Code-Requirements).
- Angular code should follow [this angular style guide](https://github.com/johnpapa/angular-styleguide).
- API responses should match the [JSON API format](http://jsonapi.org/format/).