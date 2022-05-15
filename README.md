- Master: 10 Achievements

---

## Your Assignment

<aside>
📝 **Unlocking Achievements**

You need to write the code that listens for user events and unlocks the relevant achievement.

</aside>

**For example:**

- When a user writes a comment for the first time they unlock the “First Comment Written” achievement.
- When a user has already unlocked the “First Lesson Watched” achievement by watching a single video and then watches another four videos they unlock the “5 Lessons Watched” achievement.

**AchievementUnlocked Event**

When an achievement is unlocked an **AchievementUnlocked** event must be fired with a payload of:

achievement_name (string)

user (User Model)

**BadgeUnlocked Event**

When a user unlocks enough achievement to earn a new badge a **BadgeUnlocked** event must be fired with a payload of:

badge_name (string)
user (User Model)

**Achievements Endpoint**

There is an endpoint `users/{user}/achievements` that can be found in the `web` routes file, this must return the following:

unlocked_achievements (string[ ])
An array of the user’s unlocked achievements by name

next_available_achievements (string[ ])
An array of the next achievements the user can unlock by name.

<aside>
🗒️ Note: Only the next available achievement should be returned for each group of achievements.

</aside>

<aside>
👀 Example: If the user has unlocked the “5 Lessons Watched” and “First Comment Written” achievements only the “10 Lessons Watched” and “3 Comments Written“ achievements should be returned.

</aside>

current_badge (string)
The name of the user’s current badge.

next_badge (string)
The name of the next badge the user can earn.

remaining_to_unlock_next_badge (int)
The number of additional achievements the user must unlock to earn the next badge.

<aside>
👀 Example: If a user has unlocked 5 achievements they must unlock an additional 3 achievements to earn the “Advanced” badge.

</aside>

**Test Coverage**

You should write tests that cover all possible scenarios and would, in a real world project, make you confident there are no bugs and it is safe to deploy to production.
